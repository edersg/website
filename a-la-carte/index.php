<?php
// 2011-04-30, Aurelio Jargas
// License: MIT

$svn_dir = '../svn/';
$functions_dir = $svn_dir.'zz/';
$todas = array_map("basename", glob($functions_dir.'zz*'));
$ligadas = array();
$method = $_SERVER['REQUEST_METHOD'];
$user_list = (empty($_GET['zz'])) ? null : $_GET['zz'];
$user_encoding = (empty($_GET['enc'])) ? null : $_GET['enc'];

/////////////////////////////////////////////////////////////////////
function sanitize_name($name) {
	return 'zz'.preg_replace('/^zz/', '', $name);
}

/////////////////////////////////////////////////////////////////////
// Button pressed
if ($method == 'POST') {
	
	// Force download
	header('Content-disposition: attachment; filename=funcoeszz.sh');
	header('Content-type: text/plain');
	
	// Who will be turned off?
	$ligadas = $_POST['ligadas'];
	if ($ligadas) {
		$off = implode(' ', array_diff($todas, $ligadas));  // array2str
	} else {
		$off = '';
	}
	
	// Compose and show file contents
	$magic = "test -d /tmp/zzala || mkdir /tmp/zzala; ZZOFF='$off' ZZDIR=$functions_dir ZZTMPDIR=/tmp/zzala ${svn_dir}funcoeszz --tudo-em-um";
	if ($_POST['enc'] == 'utf') {
		system($magic);
	} else {
		system($magic." | ${svn_dir}2iso-web");
	}

	// get date
	date_default_timezone_set('America/Sao_Paulo');
	$data = date('Y-m-d \a\s H:i:s');
	
	// get permalink
	$permalink = 'http://funcoeszz.net/a-la-carte/?';
	$permalink.= ($_POST['enc'] == 'iso') ? 'enc=iso&' : '';  // utf is default
	$permalink.= 'zz='.
		preg_replace('/^zz/', '',
			str_replace(',zz', ',',
				implode(',', $ligadas)));
	
	// show footer
	echo "\n";
	echo "# Arquivo gerado em $data por Funcoes ZZ a la carte\n";
	echo '# ' . $permalink . "\n";

	// Done
	exit();
}

// Compose the list of selected functions
switch ($user_list) {
	case '*':
		$ligadas = $todas;
		break;
	case 'v8':
		$ligadas = explode(' ', 'zzalfabeto zzansi2html zzarrumanome zzascii zzbeep zzbyte zzcalcula zzcalculaip zzcarnaval zzchavepgp zzcinclude zzcnpj zzcontapalavra zzconverte zzcores zzcpf zzdata zzdetransp zzdiadasemana zzdicasl zzdicbabelfish zzdicbabylon zzdicjargon zzdicportugues zzdictodos zzdiffpalavra zzdolar zzdominiopais zzdos2unix zzecho zzfoneletra zzfreshmeat zzgoogle zzhora zzhoracerta zzhorariodeverao zzhowto zzipinternet zzkill zzlimpalixo zzlinha zzlinuxnews zzlocale zzloteria zzmaiores zzmaiusculas zzminusculas zzmoeda zznatal zznomefoto zznoticiaslinux zznoticiassec zzpascoa zzpronuncia zzramones zzrot13 zzrot47 zzrpmfind zzsecurity zzsenha zzseq zzshuffle zzsigla zzss zztempo zztrocaarquivos zztrocaextensao zztrocapalavra zzuniq zzunix2dos zzwhoisbr zzwikipedia');
		break;
	case 'v10':
		$ligadas = explode(' ', 'zzalfabeto zzanatel zzansi2html zzarrumanome zzascii zzbeep zzblist zzbolsas zzbyte zzcalcula zzcalculaip zzcarnaval zzcbn zzchavepgp zzchecamd5 zzcinclude zzcinemais zzcnpj zzcontapalavra zzconverte zzcores zzcorpuschristi zzcpf zzdata zzdatabarras zzdefine zzdefinr zzdelicious zzdetransp zzdiadasemana zzdicasl zzdicbabelfish zzdicbabylon zzdicesperanto zzdicjargon zzdicportugues zzdictodos zzdiffpalavra zzdolar zzdominiopais zzdos2unix zzecho zzenglish zzenviaemail zzeuro zzextensao zzferiado zzfoneletra zzfrenteverso2pdf zzfreshmeat zzglobo zzgoogle zzhora zzhoracerta zzhoramin zzhorariodeverao zzhowto zzipinternet zzjquery zzkill zzlembrete zzlimpalixo zzlinha zzlinux zzlinuxnews zzlocale zzloteria zzmaiores zzmaiusculas zzminiurl zzminusculas zzmoeda zzmudaprefixo zznatal zznomefoto zznoticiaslinux zznoticiassec zzora zzpascoa zzpiada zzporcento zzpronuncia zzramones zzrandbackground zzrastreamento zzrelansi zzrot13 zzrot47 zzrpmfind zzsecurity zzsemacento zzsenha zzseq zzsextapaixao zzshuffle zzsigla zzss zzsubway zztempo zztradutor zztrocaarquivos zztrocaextensao zztrocapalavra zztweets zzuniq zzunix2dos zzvira zzwhoisbr zzwikipedia');
		break;
	default:
		if ($user_list) {
			// get function list from URL
			$ligadas = array_map('sanitize_name', explode(',', $user_list));
		}
}

include("description.php");


/////////////////////////////////////////////////////////////////////
?>

<html>
<head>
<title>Funções ZZ à la carte</title>
<link rel="icon" type="image/png" href="../img/favicon.png">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<style>
	body {
		margin:1em;
	}
	p {
		color: #333;
	}
	h1 {
		margin-bottom: 0;
	}
	#selecionar {
		text-align: right;
		margin-top: 0;
		font-size: 85%;
	}
	form {
		border-bottom:1px solid gray;
		padding-bottom:1em;
	}
	#lista {
		-webkit-column-count: 4;
		-moz-column-count: 4;
		column-count: 4;
	}
	label:hover {
		background: yellow;
	}
	.prefix {
		color: silver;
	}
	.arrow {
		color: silver;
		font-size: 75%;
		text-decoration: none;
		font-family: Arial,sans-serif;
	}
	.arrow:hover {
		color: blue;
	}
	#submit {
		margin-top: 1em;
		margin-right: 2em;
	}
	#encoding {
		display: inline;
		font-size: 75%;
	}
	#instrucoes {
		float: left;
		margin: 0;
		padding-bottom: 1em;
	}

	#dica {
		float: right;
		width: 14em;
		margin: 0;
		padding: 5px;
		background: #EEE;
		font-size: 90%;
		font-style: italic;
		text-align: center;
	}
</style>
</head>
<body>

<h1>Funções ZZ à la carte</h1>

<p id="selecionar">
	Selecionar:
	<a href="?zz=*">todas</a>,
	<a href=".">nenhuma</a>,
	<a href="?zz=v8">versão 8.10</a>,
	<a href="?zz=v10">versão 10.12</a>
</p>

<form method="post" action="">

	<div id="lista">
<?php
		foreach ($todas as $zz) {
?>
		<input  id="<?php echo $zz; ?>" value="<?php echo $zz; ?>" type="checkbox" name="ligadas[]"<?php if (in_array($zz, $ligadas)) echo ' checked="checked"'; ?>>
		<label for="<?php echo $zz; ?>"
			title="<?php echo $description[$zz]; ?>"><span
			class="prefix">zz</span><?php echo substr($zz, 2); ?></label>
		<a class="arrow" title="Veja o código-fonte desta função, direto do GitHub."
			href="https://github.com/funcoeszz/funcoeszz/blob/master/zz/<?php echo $zz; ?>">→</a>
		<br>
<?php
		}
?>
	</div>

	<input type="submit" id="submit" value="Baixar arquivo">

	<div id="encoding">
		<input type="radio" name="enc" id="utf" value="utf"<?php if ($user_encoding != 'iso') echo ' checked="checked"'; ?>>
		<label
			title="Baixar arquivo com a codificação UTF-8 (RECOMENDADO)"
			for="utf">UTF-8</label>

		<input type="radio" name="enc" id="iso" value="iso"<?php if ($user_encoding == 'iso') echo ' checked="checked"'; ?>>
		<label
			title="Baixar arquivo com a codificação ISO-8859-1, para usar em sistemas antigos."
			for="iso">ISO-8859-1</label>
	</div>

</form>

<p id="dica">Dica: O link permanente para sua seleção de funções estará na última linha do arquivo gerado.</p>

<p id="instrucoes">
Escolha as suas funções preferidas e aperte o botão.<br>
Um arquivo funcoeszz.sh será gerado na hora pra você.<br>
Simples assim :)<br>
<a
	title="Voltar para o site das Funções ZZ"
	style="text-decoration:none; font-family:Arial,sans-serif;"
	href="..">←</a>
</p>

<?php if (!$user_list): ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-280222-4";
urchinTracker();
</script>
<?php endif ?>

</body>
</html>
