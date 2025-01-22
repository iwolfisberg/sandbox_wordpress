import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";

// Importer le fichier de style pour l'éditeur
import "./editor.css";
// Importer le fichier de style pour le front-end
import "./style.css";

registerBlockType("custom/test-block", {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<div className="nutritional-values-display">
					<p>TEST</p>
				</div>
			</div>
		);
	},
	save: () => {
		const blockProps = useBlockProps.save();

		return (
			<div {...blockProps}>
				<div className="nutritional-values-display">
					<p>TEST</p>
				</div>
			</div>
		);
	},
});
