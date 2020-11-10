<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">
	<div class="dialogTitle">Veranstaltung bearbeiten</div>
	<legend>Pflichtfelder sind gekennzeichnet mit: <?php echo $this->REQUIRED; ?></legend>
	<section class="groupBox">
		<ul>
			<li>
				<label for="bezeichnung"><span>Bezeichnung: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="Bezeichnung" id="bezeichnung" value="<?=htmlspecialchars($this->event->bezeichnung??'')?>" required/>
			</li>
			<li>
				<label for="zeitpunkt"><span>Datum, Zeit: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="zeitpunkt" id="zeitpunkt" value="<?=htmlspecialchars($this->event->zeitpunkt??'')?>" required/>
			</li>
			<li>
				<label for="region"><span>Ort: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="ort" id="ort" value="<?=htmlspecialchars($this->event->ort??'')?>" required/>
			</li>
			<li>
				<label for="kategorie"><span>Kategorie: </span></label>
				<input class="edit" type="text" name="kategorie" id="kategorie" value="<?=htmlspecialchars($this->event->kategorie??'')?>" />
			</li>
			<li>
				<label for="bild"><span>Bild hochladen: </span></label>
				<input class="edit" type="file" name="bild" id="bild" />
			</li>
			<li>
				<label for="bild"><span>Bild aktuell: </span></label>
				<?php $this->showImage($this->event->bildId, 160, 90); ?>
			</li>
		</ul>
	</section>
	<section id="buttonSection">
		<ul>
			<li>
				<label for="submitButton" id="buttonLabel">.</label>
				<button name="action" id="submitButton" value="EventSubmit">Speichern</button>
			</li>
		</ul>
	</section>
</form>
