/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

const {
	BaseControl,
	Button,
	ExternalLink,
	PanelBody,
	PanelRow,
	Placeholder,
	SelectControl,
	SnackbarList,
	Spinner,
	TextareaControl,
	ToggleControl,
} = wp.components;

const {
	render,
	Component,
	Fragment,
	lazy, 
	Suspense
} = wp.element;

import { store as noticesStore } from '@wordpress/notices';

import {
    dispatch,
    useDispatch,
    useSelect,
} from '@wordpress/data';

/**
 * Internal dependencies
 */
import DropdownColorPicker from "./components/dropdown-color-picker";
import PanelSaveButtonRow from "./components/panel-save-button-row";
import RangeController from "./components/range-selector";

import './style.scss';

/**
 * Update Notices
 */
const Notices = () => {
    const notices = useSelect(
        ( select ) =>
            select( noticesStore )
                .getNotices()
                .filter( ( notice ) => notice.type === 'snackbar' ),
        []
    );
    const { removeNotice } = useDispatch( noticesStore );
    return (
        <SnackbarList
            className="edit-site-notices"
            notices={ notices }
            onRemove={ removeNotice }
        />
    );
};

const TitleIcon = ( icon, label ) => {
	return (
		<span className='ckexample-title-icon'>
			<span className={ 'dashicons dashicons-' + icon }></span>
			<span>{ label }</span>
		</span>
	)
}

/**
 * CK Example App Component
 */
class App extends Component {
	constructor() {
		super( ...arguments );

		this.saveSettings = this.saveSettings.bind( this );
		
		this.ckexampleData = ckexampleData || {};
		this.ckexampleData.defaults.isAPILoaded = false;
		this.ckexampleData.defaults.isAPISaving = false;
		this.state = this.ckexampleData.defaults;
		this.ns = ckexampleData.ns;
		this.i18n = ckexampleData.i18n;
	}

	componentDidMount() {
		wp.api.loadPromise.then( () => {
			this.settings = new wp.api.models.Settings();
			if ( false === this.state.isAPILoaded ) {
				this.settings.fetch().then( response => {
					response.ckexample_settings = response.ckexample_settings || {};
					response.ckexample_settings.isAPILoaded = true;
					this.setState(response.ckexample_settings);
				});
			}
		});
	}

	saveSettings( keys, message = false ) {
		this.setState({ isAPISaving: true });
		for (let key of keys) {
			this.ckexampleData.settings[key] = this.state[key];
		}
		const model = new wp.api.models.Settings({
			ckexample_settings: this.ckexampleData.settings
		});
		model.save().then( response => {
			this.setState({
				isAPISaving: false
			});
		});
		dispatch('core/notices').createNotice(
			'success',
			message = message || __( 'Settings Saved', this.ns ),
			{
				type: 'snackbar',
				isDismissible: true,
			}
		);
	}

	render() {
		if ( ! this.state.isAPILoaded ) {
			return (
				<Placeholder>
					<Spinner/>
				</Placeholder>
			);
		}

		return (
			<Fragment>
				<div className="ckexample-main">
					<PanelBody
						title={ TitleIcon('networking', __( 'Integration Settings', this.ns )) }
					>
						<PanelRow>
							<BaseControl
								label={ __( 'API Key', this.ns ) }
								help={ 'In order to use CK Example, you need to enter your API key.' }
								id="ckexample-options-api-key"
								className="ckexample-text-field"
							>
								<input
									type="text"
									id="ckexample-options-api-key"
									value={ this.state.api_key }
									placeholder={ __( 'API Key', this.ns ) }
									disabled={ this.state.isAPISaving }
									onChange={ e => this.setState({ api_key: e.target.value }) }
								/>

								<div className="ckexample-text-field-button-group">
									<ExternalLink href="#">
										{ __( 'Get API Key', this.ns ) }
									</ExternalLink>
								</div>
							</BaseControl>
						</PanelRow>
						<div>
							<RangeController
								label={ __( 'API Retry Attempts', this.ns ) }
								help={ __( 'Max amount of times to retry failed API attempts', this.ns ) }
								value={ this.state.api_timeout }
							/>
						</div>
						<PanelRow>
							<ToggleControl
								label={ __( 'Log API Interactions?', this.ns ) }
								help={ __( 'Would you like to keep a log of API Interactions?', this.ns ) }
								checked={ this.state.api_log }
								onChange={ e => this.setState({ api_log: e }) }
							/>
						</PanelRow>
						<PanelSaveButtonRow
							label={ __( 'Save Integration Settings', this.ns ) }
							isSaving={ this.state.isAPISaving } 
							onClick={ () => this.saveSettings( ['api_key','api_log'], __( 'Integration Settings Saved', this.ns ) ) } 
						/>
					</PanelBody>
					<PanelBody
						initialOpen={ false }				
 						title={ TitleIcon('art', __( 'Branding', this.ns )) }
					>
						<PanelRow>
							<DropdownColorPicker
								label={ __( 'Primary Color', this.ns ) }
								value={ this.state.primary_color }
								onChange={ e => this.setState({ primary_color: e }) }
							/>
							<DropdownColorPicker
								label={ __( 'Accent Color', this.ns ) }
								value={ this.state.accent_color }
								onChange={ e => this.setState({ accent_color: e }) }
							/>
						</PanelRow>
						<PanelRow>
							<BaseControl
								label={ __( 'Tagline', this.ns ) }
								id="ckexample-options-api-key"
								className="ckexample-text-field"
							>
								<TextareaControl
									value={ this.state.tagline }
									placeholder={ __( 'Add Tagline text', this.ns ) }
									onChange={ e => this.setState({ tagline: e }) }
								/>
							</BaseControl>
						</PanelRow>
						<PanelSaveButtonRow
							label={ __( 'Save Branding Settings', this.ns ) }
							isSaving={ this.state.isAPISaving }
							onClick={ () => this.saveSettings( ['primary_color', 'accent_color', 'tagline'], __( 'Branding Settings Saved', this.ns ) ) } 
						/>
					</PanelBody>
					<PanelBody
						initialOpen={ false }
						title={ TitleIcon('hammer', __( 'Maintenance', this.ns )) }
					>
						<PanelRow>
							<ToggleControl
								label={ __( 'Cleanup On Uninstallation', this.ns ) }
								help={ __( 'This setting will remove all CK Example plugin when uninstalled.', this.ns ) }
								checked={ this.state.cleanup }
								onChange={ e => this.setState({ cleanup: e }) }
							/>
						
						</PanelRow>
						<PanelSaveButtonRow 
							isSaving={ this.state.isAPISaving } 
							onClick={ () => this.saveSettings( ['cleanup'] ) } 
						/>
					</PanelBody>
					<PanelBody>
						<div className="ckexample-info">
							<h2>{ __( 'Got a question for us?', this.ns ) }</h2>

							<p>{ __( 'We would love to help you out if you need assistance.', this.ns ) }</p>

							<div className="ckexample-info-button-group">
								<Button
									variant="secondary"
									isLarge
									target="_blank"
									href="#"
								>
									{ __( 'Ask a question', this.ns ) }
								</Button>
								<Button
									variant="secondary"
									isLarge
									target="_blank"
									href="#"
								>
									{ __( 'Leave a review', this.ns ) }
								</Button>
							</div>
						</div>
					</PanelBody>
				</div>
				<div className="ckexample-notices">
					<Notices/>
				</div>
			</Fragment>
		);
	}
}

document.addEventListener( 'DOMContentLoaded', () => {
	const renderID = ckexampleData.renderID || false;
	console.log({
		func     : 'DOMContentLoaded',
		data     : ckexampleData,
		renderID : renderID
	});
	if( renderID ){
		const htmlOutput = document.getElementById( renderID );
		if ( htmlOutput ) {
			render(
				<App />,
				htmlOutput
			);
		}
	}
});