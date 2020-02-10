<div class="centrePage"><BR><BR><BR>
<FORM action = 'index.php?vue=langue&action=enregistrer' method = 'post'>
	<TABLE>
		<TR>
			<TD>
				Libelle de la langue
			</TD>
			<TD colspan = '2' align=left>
				<INPUT type = 'text' name = 'nomPays'/>
			</TD>
		</TR>
		<TR>
			<TD >
				Les guides qui la pratiquent
			</TD>
			<TD colspan = '2' align=left>
				<?php
				echo $_SESSION['lesGuides'];
				?>
			</TD>
		</TR>
		
		<TR>
			<TD colspan = '3' align = 'right'>
				<INPUT type = 'submit' value = 'Valider' name = 'choix'/>
			</TD>
		<TR>
	</TABLE>
</FORM>
</div>
		