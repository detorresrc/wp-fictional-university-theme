<?PHP
function pageBanner($bannerImage, $title, $subTitle)
{
    if (!$bannerImage) {
        $bannerImage = get_theme_file_uri('images/ocean.jpg');
    }
    $HTML = <<<EOF
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url({$bannerImage})"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">{$title}</h1>
        <div class="page-banner__intro">
            <p>{$subTitle}</p>
        </div>
    </div>
</div>
EOF;
    return $HTML;
}
