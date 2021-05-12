<div class="row py-3">
<div class="col-md-6 mb-4 mb-md-0">
<div class="border p-4">
<?php
$post_types = get_post_types(
    array(
        'public' => true
    ),
    'objects'
);
?>
<div class="h5 mb-3">Active types</div>
<?php
foreach ($post_types as $post_type) {
    $checked = in_array($post_type->name, $discordance_opts['types']) ? " checked" : "";
    echo <<<HTML
<div class="form-check d-flex align-items-center p-0 mb-2">
  <input class="form-check-input m-0 me-2" type="checkbox" value="{$post_type->name}" name="types[]" id="{$post_type->name}"{$checked}>
  <label class="form-check-label" for="{$post_type->name}">
    {$post_type->labels->singular_name}
  </label>
</div>
HTML;
}
?>
<p class="small m-0 text-muted">Uncheck all checkboxes to disable</p>
</div>
</div>
<div class="col-md-6">
<div class="border p-4">
<?php
$categories = get_categories(array(
  'orderby' => 'name',
  'order'   => 'ASC'
));
?>
<div class="h5 mb-3">Disabled posts categories</div>
<?php
foreach ($categories as $category) {
    $checked = isset($discordance_opts['categories']) ? (in_array($category->term_id, $discordance_opts['categories']) ? " checked" : "") : "";
    echo <<<HTML
<div class="form-check d-flex align-items-center p-0 mb-2">
  <input class="form-check-input m-0 me-2" type="checkbox" value="{$category->term_id}" name="categories[]" id="{$category->term_id}"{$checked}>
  <label class="form-check-label" for="{$category->term_id}">
    {$category->name}
  </label>
</div>
HTML;
}
?>
</div>
</div>
</div>