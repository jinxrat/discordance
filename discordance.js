const {
	data: { useSelect, useDispatch },
	plugins: { registerPlugin },
	element: { useState, useEffect },
	components: { CheckboxControl },
	editPost: { PluginPrePublishPanel, PluginDocumentSettingPanel },
} = wp;
const DiscordanceSettings = () => {
	const { meta: { _discordance_checked }, status } = useSelect((select) => ({
		meta: select('core/editor').getEditedPostAttribute('meta') || {},
		status: select('core/editor').getEditedPostAttribute('status') || {}
	}));
	const { editPost } = useDispatch('core/editor');
	const [checked, setChecked] = useState(_discordance_checked);
	useEffect(() => {
		editPost({
			meta: {
				_discordance_checked: checked
			},
		});
	}, [checked]);
	if (status === 'publish') return null;
	return (
		<>
			<PluginPrePublishPanel name='discordance' title='Discordance'>
				<CheckboxControl
					label='Send to Discord'
					checked={checked}
					onChange={setChecked}
				/>
			</PluginPrePublishPanel>
			<PluginDocumentSettingPanel name='discordance' title='Discordance'>
				<CheckboxControl
					label='Send to Discord'
					checked={checked}
					onChange={setChecked}
				/>
			</PluginDocumentSettingPanel>
		</>
	);
};
registerPlugin('discordance', {
	render: DiscordanceSettings,
	icon: null
});