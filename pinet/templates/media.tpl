{{#before}}
@include before_responsive();
{{/before}}
{{#resolutions}}
{{#resolution}}
{{#before_resolution}}
	{{before_resolution}}();
{{/before_resolution}}
@media screen and (min-width: {{value.value}}px) {
	$screen-width: {{value.value}};
	$alias-width: {{value.alias}};
	{{#prepend_resolution}}
		{{prepend_resolution}}({{value.value}});
	{{/prepend_resolution}}
	{{#sasses}}
	@include {{.}}({{value.value}}, {{value.alias}});
	{{/sasses}}
	{{#append_resolution}}
		{{append_resolution}}({{value.value}});
	{{/append_resolution}}
}
{{#after_resolution}}
	{{after_resolution}}();
{{/after_resolution}}
{{/resolution}}
{{#section}}
{{#before_section}}
	{{before_section}}();
{{/before_section}}
@media screen and (min-width: {{prev_value.value}}px) and (max-width: {{value.value}}px) {
	$screen-width: {{prev_value.value}};
	$alias-width: {{prev_value.alias}};
	$next-screen-width: {{value.value}};
	{{#sasses}}
	@include {{.}}({{prev_value.value}}, {{value.alias}}, {{value.value}});
	{{/sasses}}
}
{{#after_section}}
	{{after_section}}();
{{/after_section}}
{{/section}}
{{/resolutions}}
{{#after}}
@include after_responsive();
{{/after}}
