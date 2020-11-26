<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">
	<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: <?php echo $this->REQUIRED; ?></legend>
	<section class="groupBox">
		<ul>
			<li>
				<label for="email"><span>E-Mail: </span></label>
				<input class="edit" type="text" name="email" id="email" disabled value="<?=htmlspecialchars($this->context->user->email??'')?>"/>
			</li>
			<li>
				<label for="name"><span>Name: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="name" id="name" value="<?=htmlspecialchars($this->context->user->promoter->name??'')?>" required/>
			</li>
			<li>
				<label for="kategorie"><span>Kategorie: </span></label>
				<input class="edit" type="text" name="kategorie" id="kategorie" value="<?=htmlspecialchars($this->context->user->promoter->kategorie??'')?>" />
			</li>
			<li>
				<label for="region"><span>Region: </span></label>
				<input class="edit" type="text" name="region" id="region" value="<?=htmlspecialchars($this->context->user->promoter->region??'')?>"/>
			</li>
			<li>
				<label for="beschreibung"><span>Beschreibung: </span></label>
				<input class="edit" type="text" name="beschreibung" id="beschreibung" value="<?=htmlspecialchars($this->context->user->promoter->beschreibung??'')?>" />
			</li>
			<?php $this->showImageFragment(); ?>
			<li>
				<input class="edit" type="hidden" name="id" id="id"  value="<?=htmlspecialchars($this->context->user->promoter->id??'')?>"/>
			</li>
			<li>
				<input class="edit" type="hidden" name="bildId" id="bildId"  value="<?=htmlspecialchars($this->context->user->promoter->bildId??'')?>"/>
			</li>
			<li>
				<input class="edit" type="hidden" name="userId" id="userId"  value="<?=htmlspecialchars($this->context->user->promoter->userId??'')?>"/>
			</li>
		</ul>
	</section>
	<section id="buttonSection">
		<ul>
			<li>
				<label for="submitButton" id="buttonLabel">.</label>
				<button name="action" id="submitButton" value="PromoterSubmit">Speichern</button>
				<button name="action" id="logoutButton" value="Logout@promoterView">Abmelden</button>
			</li>
		</ul>
	</section>
</form>
