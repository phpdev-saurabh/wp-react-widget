import { createRoot, useState } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import '../css/frontend.scss';

const tabs = [
	[ 'newest', __( 'Newest', 'wp-react-widget' ) ],
	[ 'active', __( 'Active', 'wp-react-widget' ) ],
	[ 'popular', __( 'Popular', 'wp-react-widget' ) ],
];

function GroupItem( { group, type } ) {
	let meta = sprintf(
		/* translators: %s is a human-readable relative time. */
		__( 'active %s', 'wp-react-widget' ),
		group.lastActive
	);
	if ( type === 'popular' ) {
		meta = sprintf(
			/* translators: %d is the number of members in a group. */
			__( '%d members', 'wp-react-widget' ),
			group.memberCount
		);
	}
	if ( type === 'newest' && group.dateCreated ) {
		meta = sprintf(
			/* translators: %s is the group creation date. */
			__( 'created %s', 'wp-react-widget' ),
			group.dateCreated
		);
	}
	return (
		<li className="wprw-group">
			<a className="wprw-group__avatar" href={ group.permalink }>
				<img src={ group.avatarUrl } alt="" />
			</a>
			<div>
				<a className="wprw-group__name" href={ group.permalink }>
					{ group.name }
				</a>
				<span className="wprw-group__meta">{ meta }</span>
			</div>
		</li>
	);
}

function GroupsWidget( { config } ) {
	const [ type, setType ] = useState( config.defaultGroup );
	const data = config.groupsData[ type ];
	const title = config.linkTitle ? (
		<a href={ config.groupsDirectoryUrl }>{ config.title }</a>
	) : (
		config.title
	);
	return (
		<div className="wprw-groups-widget">
			{ config.title && <h2 className="widget-title">{ title }</h2> }
			<div className="item-options" role="tablist">
				{ tabs.map( ( tab ) => (
					<a
						key={ tab[ 0 ] }
						href={ config.groupsDirectoryUrl }
						role="tab"
						aria-selected={ type === tab[ 0 ] }
						className={ type === tab[ 0 ] ? 'selected' : '' }
						onClick={ ( event ) => {
							event.preventDefault();
							setType( tab[ 0 ] );
						} }
					>
						{ tab[ 1 ] }
					</a>
				) ) }
			</div>
			{ ! data.groups.length && (
				<p>
					{ __(
						'There are no groups to display.',
						'wp-react-widget'
					) }
				</p>
			) }
			{ data.groups.length > 0 && (
				<ul className="wprw-groups-widget__list">
					{ data.groups.map( ( group ) => (
						<GroupItem
							key={ group.id }
							group={ group }
							type={ type }
						/>
					) ) }
				</ul>
			) }
			{ data.total > config.maxGroups && (
				<a href={ config.groupsDirectoryUrl }>
					{ __( 'See all', 'wp-react-widget' ) }
				</a>
			) }
		</div>
	);
}

document.querySelectorAll( '.wprw-react-bb-groups' ).forEach( ( element ) => {
	try {
		createRoot( element ).render(
			<GroupsWidget config={ JSON.parse( element.dataset.wprwConfig ) } />
		);
	} catch ( error ) {
		window.console.error( 'WP React Widget:', error );
	}
} );
