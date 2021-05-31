<?php namespace Modules\Adsense\Services;

use Modules\Adsense\Entities\Ad;
use Modules\Adsense\Repositories\AdRepository;

class AdOrderer
{
    /**
     * @var AdRepository
     */
    private $adRepository;

    /**
     * @param AdRepository $ad
     */
    public function __construct(AdRepository $ad)
    {
        $this->adRepository = $ad;
    }

    /**
     * @param $data
     */
    public function handle($data)
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $position => $item) {
            $this->order($position, $item);
        }
    }

    /**
     * Order recursively the space items
     * @param int   $position
     * @param array $item
     */
    private function order($position, $item)
    {
        $ad = $this->adRepository->find($item['id']);
        $this->savePosition($ad, $position);
    }

    /**
     * Save the given position on the space item
     * @param object $ad
     * @param int    $position
     */
    private function savePosition($ad, $position)
    {
        $this->adRepository->update($ad, ['position' => $position]);
    }

    /**
     * Convert the object to array
     * @param $data
     * @return array
     */
    private function convertToArray($data)
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
