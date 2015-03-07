<?php

App::uses('AppHelper', 'View/Helper');

class PaginationHelper extends AppHelper {
	
    public $helpers = array('Html','Paginator');

	public function showPagination ($entity) {
		$content = null;
		if ($this->Paginator->request->params['paging'][$entity]['pageCount'] > 1):

			if (!isset($modules)) {
				$modulus = 11;
			}
			if (!isset($entity)) {
				$models = ClassRegistry::keys();
				// Ignore log model
				$currentModels = array_flip($models);
				unset($currentModels['log']);
				$currentModels = array_flip($currentModels);

				$entity = Inflector::camelize(current($currentModels));
			}

			$content = '<div class="pagination"><ul>';
			$content .= $this->Paginator->first('<<', array('tag' => 'li'));
			$content .= $this->Paginator->prev('<', array(
						'tag' => 'li',
						'class' => 'prev',
					), $this->Paginator->link('<', array()), array(
						'tag' => 'li',
						'escape' => false,
						'class' => 'prev disabled',
					));
			$page = $this->params['paging'][$entity]['page'];
			$pageCount = $this->params['paging'][$entity]['pageCount'];
			if ($modulus > $pageCount) {
				$modulus = $pageCount;
			}
			$start = $page - intval($modulus / 2);
			if ($start < 1) {
				$start = 1;
			}
			$end = $start + $modulus;
			if ($end > $pageCount) {
				$end = $pageCount + 1;
				$start = $end - $modulus;
			}
			for ($i = $start; $i < $end; $i++) {
				$url = array('page' => $i);
				$class = null;
				if ($i == $page) {
					$url = array();
					$class = 'active';
				}
				$content .= $this->Html->tag('li', $this->Paginator->link($i, $url), array(
					'class' => $class,
				));
			}
			$content .= $this->Paginator->next('>', array(
					'tag' => 'li',
					'class' => 'next',
				), $this->Paginator->link('>', array()), array(
					'tag' => 'li',
					'escape' => false,
					'class' => 'next disabled',
				));
			$content .= $this->Paginator->last('>>', array('tag' => 'li'));
			$content .= "</ul></div>";
		endif;
		return $content;
	}

	public function showIndex ($key, $element) {
		$page = $this->Paginator->request->params['paging'][$element]['page'];
		if ($page == 1) {
			$key = $key + 1;
		} else {
			$key = $page * 10 - 10 + $key;
		}
		return $key;
	}

}