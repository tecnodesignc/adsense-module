<?php namespace Modules\Adsense\Tests;

use Faker\Factory;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Sidebar\SidebarServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\Adsense\Entities\Ad;
use Modules\Adsense\Entities\Space;
use Modules\Adsense\Providers\AdsenseServiceProvider;
use Modules\Adsense\Repositories\AdRepository;
use Modules\Adsense\Repositories\SpaceRepository;
use Orchestra\Testbench\TestCase;
use Pingpong\Modules\ModulesServiceProvider;

abstract class BaseAdsenseTest extends TestCase
{
    /**
     * @var SpaceRepository
     */
    protected $spaceRepository;

    /**
     * @var AdRepository
     */
    protected $adRepository;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->resetDatabase();

        $this->spaceRepository = app(SpaceRepository::class);
        $this->adRepository = app(AdRepository::class);
        $this->faker = Factory::create();
    }

    protected function getPackageProviders($app)
    {
        return [
            ModulesServiceProvider::class,
            CoreServiceProvider::class,
            AdsenseServiceProvider::class,
            LaravelLocalizationServiceProvider::class,
            SidebarServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Eloquent' => Model::class,
            'LaravelLocalization' => LaravelLocalization::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('translatable.locales', ['en', 'fr']);
    }

    private function resetDatabase()
    {
        // Relative to the testbench app folder: vendors/orchestra/testbench/src/fixture
        $migrationsPath = 'Database/Migrations';
        $artisan = $this->app->make(Kernel::class);
        // Makes sure the migrations table is created
        $artisan->call('migrate', [
            '--database' => 'sqlite',
            '--path'     => $migrationsPath,
        ]);
        // We empty all tables
        $artisan->call('migrate:reset', [
            '--database' => 'sqlite',
        ]);
        // Migrate
        $artisan->call('migrate', [
            '--database' => 'sqlite',
            '--path'     => $migrationsPath,
        ]);
    }

    /**
     * @param string $name
     * @param string $systemName
     * @return Space
     */
    public function createSpace($name = 'Homepage Space', $systemName = 'homepage')
    {
        $data = [
            'name' => $name,
            'system_name' => $systemName,
            'active' => true
        ];

        return $this->spaceRepository->create($data);
    }

    /**
     * @param string $name
     * @param string $systemName
     * @param int $ads number of ads to be created
     * @return Space
     */
    public function createSpaceWithAds($name = 'Homepage Space', $systemName = 'homepage', $ads = 2)
    {
        $space = $this->createSpace($name, $systemName);

        for ($i = 1; $i <= $ads; $i++) {
            $this->createAdForSpace($space->id, $i);
        }

        return $this->spaceRepository->find($space->id);
    }

    /**
     * Create a ad for the given Space and position
     *
     * @param int $spaceId
     * @param int $position
     * @return Ad
     */
    protected function createAdForSpace($spaceId, $position)
    {
        return $this->adRepository->create($this->getAdData($spaceId, $position));
    }

    /**
     * @param int|null $spaceId
     * @param int $position
     * @return array
     */
    protected function getAdData($spaceId = null, $position = 1)
    {
        $title = implode(' ', $this->faker->words(3));
        $caption = implode(' ', $this->faker->words(10));
        $slug = Str::slug($title);

        return [
            'space_id' => $spaceId,
            'position' => $position,
            'external_image_url' => sprintf("https://placeholdit.imgix.net/~text?txtsize=50&txt=%s&w=800&h=200", $title),
            'en' => [
                'title' => $title,
                'caption' => $caption,
                'uri' => $slug,
            ],
        ];
    }
}
