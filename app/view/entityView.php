<?php
namespace App\View;
use App\Controller;
use App\Model;

	class EntityView extends FormView
	{
		protected \App\Model\Entity $entity;
		
		public function __construct($context, $entity, $title, $messages) 
		{
			parent::__construct($context, $title, $messages);
			$this->entity = $entity;
		}
		
		protected function showImageFragment()
		{
			print('<li>');
			print('	<label for="bild"><span>Bild hochladen: </span></label>');
			print('	<input class="edit" type="file" name="bild" id="bild" />');
			print('</li>');
			print('<li>');
			print('	<label for="bild"><span>Bild aktuell: </span></label>');
			$this->showImage($this->entity->bildId, 320, 180);
			print('</li>');
		}
	}
?>