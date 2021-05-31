<?php

namespace Modules\Adsense\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Badge;
use Modules\Adsense\Repositories\SpaceRepository;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAdsenseSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('adsense::adsense.title'), function (Item $item) {
                $item->weight(11);
                $item->icon('fa fa-money');
                $item->badge(function (Badge $badge, SpaceRepository $spaceRepository) {
                    $badge->setClass('bg-green');
                    $badge->setValue($spaceRepository->countAll());
                });
                $item->item(trans('adsense::space.title'), function (Item $item) {
                    $item->icon('fa fa-th-large');
                    $item->weight(0);
                    $item->append('admin.adsense.space.create');
                    $item->route('admin.adsense.space.index');
                    $item->authorize(
                        $this->auth->hasAccess('adsense.spaces.index')
                    );
                });
                $item->item(trans('adsense::stat.title'), function (Item $item) {
                    $item->icon('fa fa-line-chart');
                    $item->weight(3);
                    $item->route('admin.adsense.stat.index');
                    $item->authorize(
                        $this->auth->hasAccess('adsense.stat.index')
                    );
                });
                $item->authorize(
                    $this->auth->hasAccess('adsense.spaces.index')
                );
            });
        });

        return $menu;
    }
}
