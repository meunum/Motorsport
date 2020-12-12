<form id="<?=$this->entity->className(); ?>Form" action="index.php" enctype="multipart/form-data" method="post">
	<legend>Pflichtfelder sind gekennzeichnet mit: <?=$this->REQUIRED; ?></legend>
	<section class="groupBox">
		<ul>
            <?php $props = $this->entity->GetProps();
            foreach ($props as $key => $value) 
            {
                echo '<li><label for="', $key, '"><span>', $key, ': </span>';
                if($value[1] == 1) 
                {
                    echo $this->REQUIRED;
                }
                echo '</label>';
                echo '<input class="edit" type="text" value="', htmlspecialchars($value[0]??''), '"';
                if($value[1] == 2) 
                {
                    echo ' disabled';
                }
                echo '/></li>';
            }
            if($this->entity->bildId > 0)
            {
                echo '<li>',
                '<label for="bild"><span>Aktuelles Bild: </span></label>';
                $this->showImage($this->entity->bildId, 320, 180);
                echo '</li>';
            }?>
			<li>
				<label for="bild"><span>Bild hochladen: </span></label>
				<input class="edit" type="file" name="bild" id="bild" />
			</li>
		</ul>
        <input class="edit" type="hidden" name="id" id="id" value="<?=htmlspecialchars($this->entity->id??'0')?>" />
        <input class="edit" type="hidden" name="bildId" id="bildId"  value="<?=htmlspecialchars($this->entity->bildId??'')?>"/>
	</section>
	<section id="buttonSection" class="buttonSection">
		<ul>
			<li>
				<button class="button" name="action" id="submitButton" value="<?=$this->entity->className()?>Submit">Speichern</button>
			</li>
			<li>
				<button class="button" name="action" id="cancelButton" value="<?=$this->entity->className()?>List">Abbrechen</button>
			</li>
		</ul>
	</section>
	<section id="bottomSection" class="bottomSection">
	</section>
</form>
