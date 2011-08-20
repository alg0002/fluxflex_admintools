<?php
	$newpath = "/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin";
	$precommand = "export PATH=".$newpath." ; ";
	$adminid = "admin";
	$terminalhtml = "./ajaxterm.html";

	if( isset($_GET["init"]) ){
		// username
		$uname = trim( htmlspecialchars( shell_exec($precommand."whoami") ) );
		if( strlen($uname)==0 ){
			$uname = "<unknown user>";
		}
		// hostname
		$hname = trim( htmlspecialchars( shell_exec($precommand."hostname -a") ) );
		if( strlen($hname)==0 ){
			$hname = trim( htmlspecialchars( shell_exec($precommand."hostname -f") ) );
			$dname = trim( htmlspecialchars( shell_exec($precommand."hostname -d") ) );
			if( strlen($hname)==0 and strlen($dname)==0 ){
				$hname = "<unknown host>";
			}else{
				$hname = substr($hname, 0, strrpos($hname, $dname)-1);
			}
		}
		// current path
		$pname = trim( htmlspecialchars( shell_exec($precommand."pwd") ) );
		if( strlen($pname)==0 ){
			$pname = "<unknown path>";
		}
		print htmlspecialchars( $uname.'@'.$hname.' '.$pname );
		exit;
	}elseif( isset($_GET["logout"]) ){
		header('HTTP/1.1 401 Unauthorized');
		die("<a href='$terminalhtml'>terminal</a>");
	}elseif( isset($_POST["command"]) ){
		ob_start();
		if( isset($_SERVER["REMOTE_USER"]) and $_SERVER["REMOTE_USER"] == $adminid ){
			print htmlspecialchars( shell_exec($precommand.$_POST["command"]." ; pwd 2>&1") );
		}else{
			print "(You are not administrator. So, your command is rewrited to 'ls -l'.)\n";
			print htmlspecialchars( shell_exec($precommand."ls -l ; pwd 2>&1") );
		}
		$output = ob_get_contents();
		ob_end_clean();
		print $output;
		exit;
	}
	if( $_SERVER["HTTPS"] == 'on' ){
		$redirecturl = 'https://';
	}else{
		$redirecturl = 'http://';
	}
	$redirecturl.=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	$redirecturl=substr($redirecturl,0,strlen($redirecturl)-4).'.html';
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: $redirecturl");
?>
