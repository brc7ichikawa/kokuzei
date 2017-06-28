
				<?php if(isset($this->Paginator)) { ?>
				<?php 
					// paginatorに検索条件を渡す
					//print $this->passedArgs;
					$this->Paginator->options(array('url' => $this->Paginator->passedArgs));
				?>

				<nav>
					<ul class="pager">
						<li><?php print $this->Paginator->first("<<", array("class" => "")); ?></li>
						<li><?php print $this->Paginator->prev("<", array("class" => "")); ?> </li>
						<li><?php print $this->Paginator->counter(array("format" => "全%count%件　<strong>%page%</strong>　/　%pages%")); ?></li>
						<li><?php print $this->Paginator->next(">", array("class" => "")); ?></li>
						<li><?php print $this->Paginator->last(">>", array("class" => "")); ?></li>
					</ul>
				</nav>
				<?php } ?>
