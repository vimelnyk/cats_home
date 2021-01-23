( function( api ) {

	// Extends our custom "hexagon" section.
	api.sectionConstructor['hexagon'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );