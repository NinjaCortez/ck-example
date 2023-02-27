/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

const {
	Button,
	PanelRow
} = wp.components;

/**
 * Renders A Panel Row With a Save Button
 */

const PanelSaveButtonRow = props => {
	const { 
		isSaving, 
		onClick, 
		...attrs 
	} = props;
	let { label } = props;
	return (
		<PanelRow className="ckexample-panel-bottom-button-row">
			<Button
				isPrimary
				isLarge
				disabled={ isSaving }
				onClick={ onClick }
				{ ...attrs }
			>
				{ label = label ||  __( 'Save' ) }
			</Button>
		</PanelRow>
	);
};

export default PanelSaveButtonRow;