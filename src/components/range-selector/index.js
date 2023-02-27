/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

const { 
    BaseControl,
    RangeControl
} = wp.components;

/**
 * Renders A Stylized Range Control
 */

const RangeController = props => {
	const { 
        value,
		isSaving, 
		onChange, 
		...attrs 
	} = props;

    let {
        arrowDown,
        arrowUp,
        label, 
        help,
        marks,
        more,
        min,
        max,
        trackColor,
        railColor,
    } = props;

    arrowDown  = arrowDown  || 'arrow-down-alt2';
    arrowUp    = arrowUp    || 'arrow-up-alt2';
    more       = more       || 'more';
    trackColor = trackColor || 'green';
    railColor  = railColor  || 'red';
    min        = min        || 0;
    max        = max        || 10;

    if( ! marks ){
        marks = Array.from({length: 6}, (v, i) => ({value: i * 2, label: i * 2}));
    }

    return (
        <RangeControl
            className="ckexample-range-control"
            label={ label }
            help={ help = help || '' }
            beforeIcon={arrowDown}
            afterIcon={arrowUp}
            allowReset={false}
            resetFallbackValue={3}
            step={1}
            withInputField={false}
            icon={ more }
            separatorType="none"
            trackColor={ trackColor }
            isShiftStepEnabled
            marks={ marks }
            railColor={ railColor }
            value={ value }
            onChange={ onChange }
            min={ min }
            max={ max }
            disabled={ isSaving }
            { ...attrs }
        />
    );
};

export default RangeController;