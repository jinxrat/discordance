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
    }
