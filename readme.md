# Adsense Module

## Special Thanks
to Nicolas Widart for EncoreCMS and his Menu Module, that was used as a foundation for the Adsense Module.

## Installation
You can install Adsense module using composer:
`composer require tecnodesignc/adsense-module`

After the module is installed, you have to give yourself access in EncoreCMS (using Roles/Permissions). 
New Space item will appear in the Sidebar

## Usage

### Prerequisites
By default, Space module is created using Bootstrap Carousel http://getbootstrap.com/javascript/#carousel
so make sure you have all prerequisites loaded for standard Bootstrap carousel (Bootstrap Carousel CSS and JS)

### Basic Usage
You can create basic Space using the EncoreCMS admin interface - you can create and name your space
(pay attention to the **System Name** field here, it is used later for rendering), and create individual
ads. Ads can be linked to images in the Media module, or have URL pointing to external image.
They can also contain hyperlink to any page on the site, fixed URI or URL.

When the space is created, you can render it in your template using `{!! Space::render('space_system_name') !}}`
 
### Advanced Usage

#### Use your own space template
If you want to change rendering of your space, use custom HTML, CSS classes, etc, you can pass a Blade template
name as a second parameter to the `render()` method, i.e.
`{!! Space::render('space_system_name', 'space/my-own-space') !}}`

Template may look like this:
```php
{-- Themes/MyTheme/views/space/my-own-space.blade.php --}
<div id="{{ $space->system_name }}" class="my-own-space-class">

    @foreach($space->ads as $index => $ad)
        <div class="ad">
            <a href="{{ $ad->getLinkUrl() }}">
                <img src="{{ $ad->getImageUrl() }}" />
            </a>
        </div>
    @endforeach
    
</div>
```
You will have `Modules\Adsense\Entities\Space` instance available in the `$space` variable

#### Provide your own Space instance
You can also pass a `Modules\Adsense\Entities\Space` instance as a first parameter instead of the
space `system_name` to render dynamically created space.

First, create instance of your space and add ads in your controller and pass it to the view
```php
<?php
...
// import classes needed to create your own instance
use Modules\Adsense\Entities\Space;
use Modules\Adsense\Entities\Ad;

class HomepageController {
    ...
    /**
     * controller method
     */
    public function displayHomepage()
    {
        // make a new Space instance
        $mySpace = new Space;
        $mySpace ->system_name = 'custom_space';
        
        // create ad 1
        $ad1 = new Ad;
        $ad1->title = 'First Ad';
        $ad1->caption = 'First ad text';
        $ad1->external_image_url = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=Ad1&w=800&h=300';
        
        // create ad 2
        $ad2 = new Ad;
        $ad2->title = 'Second Ad';
        $ad2->caption = 'Second ad text';
        $ad2->external_image_url = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=Ad2&w=800&h=300';
        
        // add ads to space
        $mySpace->ads->add($ad1);
        $mySpace->ads->add($ad2);
        
        // render view
        return View::make('homepage')
            ->with('mySpace', $mySpace);
    }
    
```

then, inside of the `homepage.blade.php` template, you can render space using `{!! Adsense::render('system_name', 'template) !!}`


## Resources

- [License](LICENSE.md)
- [Encore Documentation](http://encorecms.com/docs/)
