<?php
$discordance_tags = array(
    '%tags%'=>'tag names',
    '%hashtags%'=>'tag names as hashtag',
    '%type%'=>'type name (lowercase)',
    '%title%'=>'post title',
    '%excerpt%'=>'post excerpt',
    '%image%'=>'featured image (large size)',
    '%thumbnail%'=>'post thumbnail',
    '%category%'=>'first category name OR post type name',
    '%link%'=>'post permalink',
    '%author%'=>'author display name',
    '%author_url%'=>'author url',
    '%gravatar%'=>'author avatar provided by Gravatar',
);
if (function_exists('wc_get_product')) {
    $discordance_tags = array_merge($discordance_tags, array(
        '%price%' => '',
        '%regprice%' => '',
        '%saleprice%' => ''
    ));
} ?>
<label for="format" class="h5">Embed format</label>
<div class="alert alert-danger d-none" id="format-warn">
    This format is not a valid JSON
</div>
<textarea class="form-control" name="format" id="format"><?php echo stripslashes($discordance_opts['format']); ?></textarea>
<div class="border-top border-bottom py-3">
    <div class="btn-group dropend">
        <button id="pretty" type="button" class="btn btn-outline-primary">Pretty JSON</button>
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownVars" data-bs-toggle="dropdown" aria-expanded="false">
            Variables
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownVars">
        <?php foreach ($discordance_tags as $tag => $title) {
        echo '<li><button class="dropdown-item variable" data-bs-placement="right" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="'.$title.'">'.$tag.'</button>';
    }?>
        </ul>
    </div>
</div>
<p class="small m-0 mt-3 text-muted">
    <strong>Embed Visualizer:</strong>
    <a href="https://leovoel.github.io/embed-visualizer/" class="text-muted"
        target="_blank">https://leovoel.github.io/embed-visualizer/</a> (don't forget to activate webhook mode)
</p>