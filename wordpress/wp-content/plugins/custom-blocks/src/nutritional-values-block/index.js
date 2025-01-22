import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";
import { TextControl, PanelBody, PanelRow } from "@wordpress/components";
import { InspectorControls } from "@wordpress/block-editor";

// Importer le fichier de style pour l'éditeur
import "./editor.css";
// Importer le fichier de style pour le front-end
import "./style.css";

registerBlockType("custom/nutritional-values-block", {
	edit: ({ attributes, setAttributes }) => {
		const { calories, proteins, carbs, fats } = attributes;

		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Valeurs nutritionnelles" initialOpen={true}>
						<PanelRow>
							<TextControl
								label="Calories (kcal) / personnes"
								value={calories}
								onChange={(value) => setAttributes({ calories: value })}
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Protéines (g)"
								value={proteins}
								onChange={(value) => setAttributes({ proteins: value })}
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Glucides (g)"
								value={carbs}
								onChange={(value) => setAttributes({ carbs: value })}
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Lipides (g)"
								value={fats}
								onChange={(value) => setAttributes({ fats: value })}
							/>
						</PanelRow>
					</PanelBody>
				</InspectorControls>

				<div className="nutritional-values-display">
					<p>
						<strong>Calories :</strong> {calories} kcal
					</p>
					<p>
						<strong>Protéines :</strong> {proteins} g.
					</p>
					<p>
						<strong>Glucides :</strong> {carbs} g.
					</p>
					<p>
						<strong>Lipides :</strong> {fats} g.
					</p>
				</div>
			</div>
		);
	},
	save: ({ attributes }) => {
		const { calories, proteins, carbs, fats } = attributes;
		const blockProps = useBlockProps.save();

		return (
			<div {...blockProps}>
				<div className="nutritional-values-display">
					<p>
						<strong>Calories :</strong> {calories} kcal
					</p>
					<p>
						<strong>Protéines :</strong> {proteins} g.
					</p>
					<p>
						<strong>Glucides :</strong> {carbs} g.
					</p>
					<p>
						<strong>Lipides :</strong> {fats} g.
					</p>
				</div>
			</div>
		);
	},
});
