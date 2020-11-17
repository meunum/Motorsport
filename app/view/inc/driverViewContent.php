<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">
	<legend>Pflichtfelder sind gekennzeichnet mit: <?php echo $this->REQUIRED; ?></legend>
	<section class="groupBox">
		<ul>
			<li>
				<label for="name"><span>Name: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="name" id="name" value="<?=htmlspecialchars($this->driver->name??'')?>"/>
			</li>
			<li>
				<label for="vorname"><span>Vorname: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="vorname" id="vorname" value="<?=htmlspecialchars($this->driver->vorname??'')?>"/>
			</li>
			<li>
				<label for="Anmerkung"><span>anmerkung: </span><?php echo $this->REQUIRED; ?></label>
				<input class="edit" type="text" name="anmerkung" id="anmerkung" value="<?=htmlspecialchars($this->driver->anmerkung??'')?>"/>
			</li>
			<li>
				<label for="bild"><span>Bild hochladen: </span></label>
				<input class="edit" type="file" name="bild" id="bild" />
			</li>
			<li>
				<label><span>Bild aktuell: </span></label>
				<?php $this->showImage($this->driver->bildId, 160, 90); ?>
			</li>
			<li>
				<input class="edit" type="hidden" name="id" id="id" value="<?=htmlspecialchars($this->driver->id??'0')?>" />
			</li>
			<li>
				<input class="edit" type="hidden" name="bildId" id="bildId"  value="<?=htmlspecialchars($this->driver->bildId??'')?>"/>
			</li>
		</ul>
	</section>
	<section id="buttonSection">
		<ul>
			<li>
				<label for="submitButton" id="buttonLabel">.</label>
				<button name="action" id="submitButton" value="DriverSubmit">Speichern</button>
			</li>
			<li>
				<label for="cancelButton" id="buttonLabel">.</label>
				<button name="action" id="cancelButton" value="ShowPromoterDriverList">Abbrechen</button>
			</li>
		</ul>
	</section>
</form>
 