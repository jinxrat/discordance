const {
	data: { useSelect, useDispatch },
	plugins: { registerPlugin },
	element: { useState, useEffect },
	components: { CheckboxControl },
	editPost: {
		PluginPrePublishPanel,
		PluginDocumentSettingPanel
	},
	apiRequest
} = wp;
apiRequest({
	path: '/discordance/v1/options'
}).then(options => {
	const DiscordanceSettings = () => {
		const { categories, meta: { _discordance_checked }, status, type } = useSelect((select) => ({
			meta: select('core/editor').getEditedPostAttribute('meta') || {},
			categories: select('core/editor').getEditedPostAttribute('categories') || {},
			status: select('core/editor').getEditedPostAttribute('status') || {},
			type: select('core/editor').getEditedPostAttribute('type')
		}));
		const { editPost } = useDispatch('core/editor');
		const [checked, setChecked] = useState(_discordance_checked);
		useEffect(() => {
			editPost({ meta: { _discordance_checked: checked } });
		}, [checked]);
		if (!options.active_types.includes(type)) return null;
		if (options.disabled_categories_ids.some(id => {
			const category_id = parseInt(id);
			return categories.includes(category_id);
		})) return null;
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
	}; 12
	registerPlugin('discordance', {
		render: DiscordanceSettings,
		icon: null
	});
});