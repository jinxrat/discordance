<div class="wrap" id="discordance">
    <h1 class="wp-heading-inline">
        <?php echo get_admin_page_title() ?>
    </h1>
    <?php
    if (isset($_POST['webhooks']) && isset($_POST['format'])) {
        $discordance_opts['webhooks'] = sanitize_textarea_field($_POST['webhooks']);
        $discordance_opts['format'] = wp_encode_emoji($_POST['format']);
        $discordance_opts['types'] = isset($_POST['types']) && is_array($_POST['types']) ? $_POST['types'] : [];
        $discordance_opts = filter_var_array($discordance_opts, FILTER_SANITIZE_STRING);
        update_option('discordance', $discordance_opts);
        echo <<<HTML
    <div class="updated notice is-dismissible" id="discordance-update-prompt">
		<p>
			<strong>Updated settings</strong>
		</p>
    </div>
HTML;
    } ?>
    <hr class="wp-header-end">
    <form method="post" novalidate="novalidate">
        <div class="discordance-content discordance-webhooks">
            <label for="webhooks" class="block-bold">Discord Webhooks</label>
            <textarea name="webhooks" id="webhooks"
                placeholder="https://discord.com/api/webhooks/id/token"><?php echo $discordance_opts['webhooks']; ?></textarea>
            <p class="description">One Discord Webhook per line</p>
        </div>
        <div class="discordance-content discordance-embed-format">
            <label for="format" class="block-bold">Embed format</label>
            <textarea name="format" id="format"><?php echo stripslashes($discordance_opts['format']); ?></textarea>
            <button id="pretty" class="button button-primary">Pretty JSON</button>
            <div id="format-warn" class="discordance-format-warning">This format is not a valid JSON</div>
            <p class="description">
                <strong>Embed Visualizer:</strong>
                <a href="https://leovoel.github.io/embed-visualizer/"
                    target="_blank">https://leovoel.github.io/embed-visualizer/</a> (don't forget to activate webhook mode)
            </p>
            <hr />
            <div id="helper">
                <p class="variables">
                    <strong>Available variables:</strong>
                    <span class="button button-primary">%tags%<span>tag names</span></span>
                    <span class="button button-primary">%hashtags%<span>tag names as hashtags</span></span>
                    <span class="button button-primary">%type%<span>type name (lowercase)</span></span>
                    <span class="button button-primary">%title%<span>post title</span></span>
                    <span class="button button-primary">%excerpt%<span>post excerpt</span></span>
                    <span class="button button-primary">%image%<span>featured image (large size)</span></span>
                    <span class="button button-primary">%thumbnail%<span>post thumbnail</span></span>
                    <span class="button button-primary">%category%<span>first category name OR post type name</span></span>
                    <span class="button button-primary">%link%<span>post permalink</span></span>
                    <span class="button button-primary">%author%<span>author display name</span></span>
                    <span class="button button-primary">%author_url%<span>author url</span></span>
                    <span class="button button-primary">%gravatar%<span>author avatar provided by <a
                        href="https://en.gravatar.com/connect/" target="_blank">Gravatar</a></span></span>
                </p>
            </div>
        </div>
        <div class="discordance-content">
        <?php include("custom_types.php") ?>
        </div>
        <div class="discordance-content submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Update settings">
            <div style="display: flex; float: right; align-items: center;">
                <a href="https://github.com/jinxrat/discordance" target="_blank" style="height: 36px; margin-right: 10px;">
                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgeG1sbnM6c29kaXBvZGk9Imh0dHA6Ly9zb2RpcG9kaS5zb3VyY2Vmb3JnZS5uZXQvRFREL3NvZGlwb2RpLTAuZHRkIgogICB4bWxuczppbmtzY2FwZT0iaHR0cDovL3d3dy5pbmtzY2FwZS5vcmcvbmFtZXNwYWNlcy9pbmtzY2FwZSIKICAgdmlld0JveD0iMCAwIDUwMCA1MDAiCiAgIHZlcnNpb249IjEuMSIKICAgaWQ9InN2ZzM0IgogICBzb2RpcG9kaTpkb2NuYW1lPSJkaXNjb3JkYW5jZS5zdmciCiAgIGlua3NjYXBlOnZlcnNpb249IjEuMC4yLTIgKGU4NmM4NzA4NzksIDIwMjEtMDEtMTUpIj4KICA8bWV0YWRhdGEKICAgICBpZD0ibWV0YWRhdGE0MCI+CiAgICA8cmRmOlJERj4KICAgICAgPGNjOldvcmsKICAgICAgICAgcmRmOmFib3V0PSIiPgogICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2Uvc3ZnK3htbDwvZGM6Zm9ybWF0PgogICAgICAgIDxkYzp0eXBlCiAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4KICAgICAgPC9jYzpXb3JrPgogICAgPC9yZGY6UkRGPgogIDwvbWV0YWRhdGE+CiAgPGRlZnMKICAgICBpZD0iZGVmczM4IiAvPgogIDxzb2RpcG9kaTpuYW1lZHZpZXcKICAgICBwYWdlY29sb3I9IiNmZmZmZmYiCiAgICAgYm9yZGVyY29sb3I9IiM2NjY2NjYiCiAgICAgYm9yZGVyb3BhY2l0eT0iMSIKICAgICBvYmplY3R0b2xlcmFuY2U9IjEwIgogICAgIGdyaWR0b2xlcmFuY2U9IjEwIgogICAgIGd1aWRldG9sZXJhbmNlPSIxMCIKICAgICBpbmtzY2FwZTpwYWdlb3BhY2l0eT0iMCIKICAgICBpbmtzY2FwZTpwYWdlc2hhZG93PSIyIgogICAgIGlua3NjYXBlOndpbmRvdy13aWR0aD0iMTkyMCIKICAgICBpbmtzY2FwZTp3aW5kb3ctaGVpZ2h0PSIxMDE3IgogICAgIGlkPSJuYW1lZHZpZXczNiIKICAgICBzaG93Z3JpZD0iZmFsc2UiCiAgICAgaW5rc2NhcGU6em9vbT0iMS43IgogICAgIGlua3NjYXBlOmN4PSIyNTAiCiAgICAgaW5rc2NhcGU6Y3k9IjE0OC45NzE3NyIKICAgICBpbmtzY2FwZTp3aW5kb3cteD0iMTkxMiIKICAgICBpbmtzY2FwZTp3aW5kb3cteT0iLTgiCiAgICAgaW5rc2NhcGU6d2luZG93LW1heGltaXplZD0iMSIKICAgICBpbmtzY2FwZTpjdXJyZW50LWxheWVyPSJzdmczNCIgLz4KICA8cGF0aAogICAgIGlkPSJyZWN0MjYiCiAgICAgc3R5bGU9ImZpbGw6IHJnYigxMTQsIDEzNywgMjE4KTsiCiAgICAgZD0iTSAxNi4yNzM0MzggMTYuMjczNDM4IEwgMTYuMjczNDM4IDQ4My43MjY1NiBMIDQ4My43MjY1NiA0ODMuNzI2NTYgTCA0ODMuNzI2NTYgMTYuMjczNDM4IEwgMTYuMjczNDM4IDE2LjI3MzQzOCB6IE0gNzcuMTUyMzQ0IDcyLjUgTCA0MjcuNSA3Mi41IEwgNDI3LjUgNDI2LjM3MzA1IEwgNzQuMjQ4MDQ3IDQyNi4zNzMwNSBMIDcyLjUgNDI3LjUgTCA3My4wNDg4MjggNDI2Ljk2Mjg5IEwgNzMuMDQ4ODI4IDM3NS42NjAxNiBMIDExNy4zOTY0OCAzNzUuNjYwMTYgTCAxMTcuMzk2NDggMTIzLjQxOTkyIEwgNzcuMTUyMzQ0IDEyMy40MTk5MiBMIDc3LjE1MjM0NCA3Mi41IHogTSAyNzUgMTI0IEwgMjc1IDI1OSBMIDMwOCAyNTkgTCAzMDggMTI0IEwgMjc1IDEyNCB6IE0gMzUwIDEyNCBMIDM1MCAyNTkgTCAzODMgMjU5IEwgMzgzIDEyNCBMIDM1MCAxMjQgeiAiIC8+Cjwvc3ZnPgo="
                    style="width: 36px;"></a>
                    <a href="https://jinxr.at/donate" target="_blank" style="text-decoration: none; font-weight: 700; color: #777">Buy Me A Coffee</a>
            </div>
        </div>
    </form>
</div>