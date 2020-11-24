<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">
	<legend>Pflichtfelder sind gekennzeichnet mit: <?php echo $this->REQUIRED; ?></legend>
	<section class="groupBox">
		<ul>
			<li>
				<label for="bezeichnung"><span>Bezeichnung: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="bezeichnung" id="bezeichnung" value="<?=htmlspecialchars($this->event->bezeichnung??'')?>"/>
			</li>
			<li>
				<label for="zeitpunkt"><span>Datum, Zeit: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="zeitpunkt" id="zeitpunkt" value="<?=htmlspecialchars($this->event->zeitpunkt??'')?>"/>
			</li>
			<li>
				<label for="ort"><span>Ort: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="ort" id="ort" value="<?=htmlspecialchars($this->event->ort??'')?>"/>
			</li>
			<li>
				<label for="kategorie"><span>Kategorie: </span></label>
				<input class="edit" type="text" name="kategorie" id="kategorie" value="<?=htmlspecialchars($this->event->kategorie??'')?>" />
			</li>
			<?php $this->ShowImageFragment(); ?>
			<li>
				<input class="edit" type="hidden" name="id" id="id" value="<?=htmlspecialchars($this->event->id??'0')?>" />
			</li>
			<li>
				<input class="edit" type="hidden" name="bildId" id="bildId"  value="<?=htmlspecialchars($this->event->bildId??'')?>"/>
			</li>
		</ul>
	</section>
	<section id="buttonSection" class="buttonSection">
		<ul>
			<li>
				<button class="button" name="action" id="submitButton" value="EventSubmit">Speichern</button>
			</li>
			<li>
				<button class="button" name="action" id="cancelButton" value="EventList">Abbrechen</button>
			</li>
		</ul>
		<br>
	</section>
</form>
