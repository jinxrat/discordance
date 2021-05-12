<label for="webhooks" class="h5">Discord Webhooks (default)</label>
<textarea class="form-control" name="webhooks" id="webhooks" placeholder="https://discord.com/api/webhooks/id/token"><?php echo $discordance_opts['webhooks']; ?></textarea>
<p class="small m-0 text-muted">One Discord Webhook per line</p>
<?php
$post_types = get_post_types(
    array(
        'public' => true
    ),
    'objects'
);
foreach ($post_types as $post_type) {
    $webhook = isset($discordance_opts['webhook-' . $post_type->name]) ? $discordance_opts['webhook-' . $post_type->name] : '';
    echo <<<HTML
<div class="border p-3 my-4">
<label for="{$post_type->name}webhook" class="h5">Discord Webhook for {$post_type->labels->name}</label>
<input class="form-control"
    name="webhook-{$post_type->name}"
    id="{$post_type->name}webhook"
    placeholder="https://discord.com/api/webhooks/id/token"
    value="{$webhook}"
    type="text">
</div>
HTML;
}
?>