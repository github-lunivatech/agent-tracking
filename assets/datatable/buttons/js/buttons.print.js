/*!
 * Print button for Buttons and DataTables.
 * 2016 SpryMedia Ltd - datatables.net/license
 */

(function( factory ){
	if ( typeof define === 'function' && define.amd ) {
		// AMD
		define( ['jquery', 'datatables.net', 'datatables.net-buttons'], function ( $ ) {
			return factory( $, window, document );
		} );
	}
	else if ( typeof exports === 'object' ) {
		// CommonJS
		module.exports = function (root, $) {
			if ( ! root ) {
				root = window;
			}

			if ( ! $ || ! $.fn.dataTable ) {
				$ = require('datatables.net')(root, $).$;
			}

			if ( ! $.fn.dataTable.Buttons ) {
				require('datatables.net-buttons')(root, $);
			}

			return factory( $, root, root.document );
		};
	}
	else {
		// Browser
		factory( jQuery, window, document );
	}
}(function( $, window, document, undefined ) {
'use strict';
var DataTable = $.fn.dataTable;


var _link = document.createElement( 'a' );

/**
 * Clone link and style tags, taking into account the need to change the source
 * path.
 *
 * @param  {node}     el Element to convert
 */
var _styleToAbs = function( el ) {
	var url;
	var clone = $(el).clone()[0];
	var linkHost;

	if ( clone.nodeName.toLowerCase() === 'link' ) {
		clone.href = _relToAbs( clone.href );
	}

	return clone.outerHTML;
};

/**
 * Convert a URL from a relative to an absolute address so it will work
 * correctly in the popup window which has no base URL.
 *
 * @param  {string} href URL
 */
var _relToAbs = function( href ) {
	// Assign to a link on the original page so the browser will do all the
	// hard work of figuring out where the file actually is
	_link.href = href;
	var linkHost = _link.host;

	// IE doesn't have a trailing slash on the host
	// Chrome has it on the pathname
	if ( linkHost.indexOf('/') === -1 && _link.pathname.indexOf('/') !== 0) {
		linkHost += '/';
	}

	return _link.protocol+"//"+linkHost+_link.pathname+_link.search;
};


DataTable.ext.buttons.print = {
	className: 'buttons-print',

	text: function ( dt ) {
		return dt.i18n( 'buttons.print', 'Print' );
	},

	action: function ( e, dt, button, config ) {
		var data = dt.buttons.exportData(
			$.extend( {decodeEntities: false}, config.exportOptions ) // XSS protection
		);
		var exportInfo = dt.buttons.exportInfo( config );

		var addRow = function ( d, tag ) {
			var str = '<tr>';

			for ( var i=0, ien=d.length ; i<ien ; i++ ) {
				str += '<'+tag+'>'+d[i]+'</'+tag+'>';
			}

			return str + '</tr>';
		};

		var addHeadRow = function ( d, tag ) {
			var str = '<tr>';

			for ( var i=0, ien=d.length ; i<ien ; i++ ) {
				str += '<'+tag+'>'+d[i].split('_').join(' ')+'</'+tag+'>';
			}

			return str + '</tr>';
		};

		// Construct a table for printing
		var html = '<table class="'+dt.table().node().className+'">';

		if ( config.header ) {
			html += '<thead>'+ addHeadRow( data.header, 'th' ) +'</thead>';
		}

		html += '<tbody>';
		for ( var i=0, ien=data.body.length ; i<ien ; i++ ) {
			html += addRow( data.body[i], 'td' );
		}

		html += table_total.getTableRow();

		html += '</tbody>';

		if ( config.footer && data.footer ) {
			html += '<tfoot>'+ addRow( data.footer, 'th' ) +'</tfoot>';
		}
		html += '</table>';

		// Open a new window for the printable table
		var win = window.open( '', '' );
		win.document.close();

		// Inject the title and also a copy of the style and link tags from this
		// document so the table can retain its base styling. Note that we have
		// to use string manipulation as IE won't allow elements to be created
		// in the host document and then appended to the new window.
		var head = '<title>'+exportInfo.title+'</title>';
		$('style, link').each( function () {
			head += _styleToAbs( this );
		} );

		try {
			win.document.head.innerHTML = head; // Work around for Edge
		}
		catch (e) {
			$(win.document.head).html( head ); // Old IE
		}

		// Inject the table and other surrounding information
		// win.document.body.innerHTML =
		// 	'<h1>'+exportInfo.title+'</h1>'+
		// 	'<div>'+(exportInfo.messageTop || '')+'</div>'+
		// 	html+
		// 	'<div>'+(exportInfo.messageBottom || '')+'</div>';
		
		/*************************************************************** */
		
		//defining page orientation on the basic of number of table column
		var total_table_heads = document.querySelector('#ird-table tr').childNodes.length;
		var page_css = '';

		var page_head = win.document.head,
			page_style = document.createElement('style');
			page_style.type = 'text/css';
			page_style.media = 'print';	

		if( total_table_heads > 8 ){
			page_css = '@page{size:landscape;}';
			page_css += 'tbody tr td{padding-top:1px !important;padding-bottom:1px !important;}';
			if(total_table_heads > 10)
				page_css += 'table.dataTable thead th, table.dataTable thead td,table.dataTable tbody th, table.dataTable tbody td{padding:5px; font-size:0.81em;}';

		}else{
			page_css = '@page{size:A4;}';
			page_css += 'tbody tr td{padding-top:1px !important;padding-bottom:1px !important;}';
		}

		page_style.appendChild( document.createTextNode( page_css ) );

		page_head.appendChild( page_style );
		/*********************************************************************** */

		win.document.body.innerHTML =
			'<div style="text-align:center;">'+
				'<h1>'+document.getElementById('fin_CmpName').innerHTML+'</h1>'+
				'<h4>'+ document.getElementById('fin_CmpAddress').innerHTML +'</h4>'+
				'<h2 style="font-size:30px;">'+ $('#report-type option[value='+ document.getElementById('report-type').value +']').text().trim() +'</h2>'+
			'</div>'+
			'</span>PAN no.: '+ document.getElementById('fin_CmpTPIN').innerHTML +'</span></br>'+
			'<span>Date From: '+ document.getElementById('fromDate').value+' To: '+ document.getElementById('toDate').value +'</span>'+
			'<div>'+(exportInfo.messageTop || '')+'</div>'+
			html+
			'<div>'+(exportInfo.messageBottom || '')+'</div>';
		/***************************************************************************************** */

		$(win.document.body).addClass('dt-print-view');

		$('img', win.document.body).each( function ( i, img ) {
			img.setAttribute( 'src', _relToAbs( img.getAttribute('src') ) );
		} );

		if ( config.customize ) {
			config.customize( win );
		}

		// Allow stylesheets time to load
		setTimeout( function () {
			
			if ( config.autoPrint ) {
				win.print();
				win.onafterprint = function(){win.close(); }
			}
		}, 1000 );
	},

	title: '*',

	messageTop: '*',

	messageBottom: '*',

	exportOptions: {},

	header: true,

	footer: false,

	autoPrint: true,

	customize: null
};


return DataTable.Buttons;
}));
