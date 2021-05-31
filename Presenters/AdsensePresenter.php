<?php

namespace Modules\Adsense\Presenters;
use Illuminate\Support\Facades\View;
use Modules\Adsense\Entities\Space;

class AdsensePresenter extends AbstractAdsensePresenter implements AdsensePresenterInterface
{

    /**
     * renders space.
     * @param string|Space $space
     * pass Space instance to render specific space
     * pass string to automatically retrieve space from repository
     * @param string $template blade template to render space
     * @return string rendered space HTML
     */
    public function render($space, $template = 'adsense::frontend.bootstrap.space', $options=array())
    {
        if (!$space instanceof Space) {
            $space = $this->getSpaceFromRepository($space);
            if ($space && $space->active == false) {    // inactive space must not render
                return '';
            }
        }
        if (!$space) {
            return '';
        }

        $view = View::make($template)
            ->with([
                'space' => $space,
                'options'=>$options
            ]);

        return $view->render();
    }


    /**
     * @param $systemName
     * @return Space
     */
    private function getSpaceFromRepository($systemName)
    {
        return $this->spaceRepository->findBySystemName($systemName);
    }
}
