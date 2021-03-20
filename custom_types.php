<?php
$post_types = get_post_types(
    array(
        'public' => true
    ),
    'objects'
);
?>
<h4 class="block-bold">Active types</h4>
<?php
foreach ($post_types as $post_type) {
    $checked = in_array($post_type->name, $discordance_opts['types']) ? " checked " : "";
    echo '<label><input type="checkbox" name="types[]" value="' . $post_type->name . '" ' . $checked . '>' . $post_type->labels->singular_name . "</label>\n";
}
?>
<p class="description">Uncheck all checkboxes to disable</p>