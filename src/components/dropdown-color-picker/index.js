/**
 * WordPress dependencies
 */
const {
	Button,
	Dropdown,
	ColorIndicator,
	ColorPicker,
	Tooltip
} = wp.components;

const DropdownColorPicker = props => {
	const {
		label,
		value,
		onChange,
		...attrs 
	} = props;
	return (
		<Dropdown
			className="components-color-palette__item-wrapper"
			contentClassName="components-color-palette__picker"	
			renderToggle={ ( { isOpen, onToggle } ) => (
				<Button
					className="components-color-palette__item"
					onClick={ onToggle }
					aria-expanded={ isOpen }
					{ ...attrs }
				>
					<ColorIndicator colorValue={ value } />
					{ label && ( <span>{ label }</span> ) }
				</Button>
			) }
			renderContent={ () => (
				<ColorPicker
					color={ value }
					onChangeComplete={ ( color ) => onChange( color.hex ) }
					disableAlpha
				/>
			) }
		/>
	);
};

export default DropdownColorPicker;