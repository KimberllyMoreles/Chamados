<?php 
	pg_connect("host=localhost user=postgres password=postgres dbname=chamados port=5432");

	echo '
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Chamados</title>
		<script type="text/javascript" src="js/jquery-1.12.2.js"></script>
		
		<script src="js/glow/1.7.0/core/core.js" type="text/javascript"></script>
		<script src="js/glow/1.7.0/widgets/widgets.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" language="javascript" src="js/DataTable/jquery.dataTables.js"></script>	
		<script type="text/javascript" language="javascript" src="js/DataTable/jquery.dataTables.min.js"></script>		
		<link rel="stylesheet" href="css/960.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/template.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/colour.css" type="text/css" media="screen" charset="utf-8" />
		<link href="js/glow/1.7.0/widgets/widgets.css" type="text/css" rel="stylesheet" />
		<link rel="stylesheet" href="css/jquery.dataTables.css" type="text/css" media="screen" charset="utf-8" />
		<script src="js/javascript.helpers.js" type="text/javascript"></script>
		<!-- calendar stylesheet -->
		<link rel="stylesheet" type="text/css" media="all" href="js/jscalendar-1.0/skins/aqua/theme.css" title="win2k-cold-1" />

		<!-- main calendar program -->
		<script type="text/javascript" src="js/jscalendar-1.0/calendar.js"></script>

		<!-- language for the calendar -->
		<script type="text/javascript" src="js/jscalendar-1.0/lang/calendar-br.js"></script>

		<!-- the following script defines the Calendar.setup helper function, which makes
			adding a calendar a matter of 1 or 2 lines of code. -->
		<script type="text/javascript" src="js/jscalendar-1.0/calendar-setup.js"></script>		
		<style>
			label{
				display: block;
	   		}
			.window{
				display:none;
				position:absolute;
				left:0;
				top:0;
				background:#FFF;
				z-index:99;
				padding:25px;
				border-radius:10px;
			}
			#mascara{
				display:none;
				position:absolute;
				left:0;
				top:0;
				z-index:90;
				background-color:#000;
			}
			.fechar{display:block; text-align:right;}
		</style>
	</head>';
