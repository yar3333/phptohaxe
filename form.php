<form method="post">
	<?php
		# Input variables: $mode, $srcHint, $destHint.

		require_once(dirname(__FILE__) . '/support/PhpToHaxe.php');
		
		function getIntMode($mode)
		{
			switch ($mode)
			{
				case 'code' : return PhpToHaxe::MODE_CODE;
				case 'extern' : return PhpToHaxe::MODE_EXTERN_CODE;
				case 'methods' : return PhpToHaxe::MODE_DOC_METHODS;
				case 'consts' : return PhpToHaxe::MODE_DOC_CONSTS;
			};
		}
		
		function prepareForTextarea($text)
		{
			if (preg_match('/(?i)msie /',$_SERVER['HTTP_USER_AGENT']))
			{		
				$text = str_replace("\r\n", "\n", $text);
				$text = str_replace("\r", "\n", $text);
				$text = str_replace("\n", "<br/>", $text);
				$text = str_replace(" ", "&nbsp;", $text);
			}
			return $text;
		}
	?>

	<h2>PhpToHaxe - tool for helping use php from haxe</h2>

	<?php require dirname(__FILE__) . "/menu.php"; ?>

	<table width="100%" class="phptohaxe">
		<tr>
			<td width="50%">
				<p id="srcHint" style="margin: 5px 0"><?php echo $srcHint ?></p>
				<textarea name="phpCode" wrap="off" spellcheck='false'><?php
					if (isset($_REQUEST["phpCode"]))
					{
						echo $_REQUEST["phpCode"];
					}
					else
					{
						echo prepareForTextarea(PhpToHaxe::getExampleCodeToConvert(getIntMode($mode)));
					}
					
				?></textarea>
			</td>
			<td align="center" valign="middle" style="padding: 0 10px">
				<input type="submit" id="convert" value="=>" />
			</td>
			<td width="50%">
				<p id="destHint" style="margin: 5px 0"><?php echo $destHint ?></p>
				<textarea name="haxeCode" readonly='readonly' wrap="off" spellcheck='false'><?php
					$phpToHaxe = PhpToHaxe::create(getIntMode($mode));
					if (isset($_REQUEST["phpCode"]))
					{
						echo prepareForTextarea($phpToHaxe->getHaxeCode($_REQUEST["phpCode"]));
					}
					else
					{
						echo prepareForTextarea($phpToHaxe->getHaxeCode(PhpToHaxe::getExampleCodeToConvert(getIntMode($mode))));
					}
				?></textarea>
			</td>
		</tr>
	</table>
</form>