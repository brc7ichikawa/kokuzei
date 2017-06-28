<?php $this->set('title_for_layout', (isset($title) ? $title : '税務署検索 | 東京都の税務署を検索,東京都所轄の税務署を検索' ));?> 
<?php $this->Html->meta('keywords', (isset($keywords) ? $keywords : "東京都,税務署,検索,所轄"), array('inline' => false)); ?> 
<?php $this->Html->meta('description', (isset($description) ? $description : "住所から東京都管轄の各税務署を検索します。,所轄の税務署を検索します"), array('inline' => false)); ?> 
<?php $this->Html->css('bootstrap-custom.css', null, array('inline' => false)); ?> 
<?php print $this->Html->script("/js/geo_location.js", array( 'inline' => false));?> 
<?php print $this->Html->script("/js/mobile_hide_show.js", array( 'inline' => false));?> 
<input type="hidden" id="is_mobile" value="<?php print ($this->request->is('mobile') ? "true" : "false");?>" />
<div class="bs-docs-section">
 <h2>税務署を検索します</h2>
 <p><h4><?php print (isset($address_name) ? $address_name : "入力した住所")?>から所轄の税務署</h4>を検索出来ます。</p>
 <p>確定申告や税務処理の際にお役立て下さい。</p>
 
 <span id="news_doc">	
 <?php if($this->request->is('mobile')) { ?>
 <p><img src="/img/new.png" />16.09.07 モバイル用に最適化を行いました。住所は<img width="25px" src="/img/map2.png" />を押すとgoogle mapにて確認できます。</p>
 <p><span class="text-danger">電話番号と税務署番号は「その他&gt;&gt;」を押すと表示されます</span></p>
 <?php } ?>
 <!--<p><span class="text-danger">16.03.07 19時頃〜21時頃までサーバ障害により閲覧不能となりました、</span></p>
 <p><span class="text-danger">閲覧されていた皆様にはご迷惑をおかけし大変申し訳ございませんでした。</span></p><br />-->
 <p><span class="text-danger">※ご注意　〜丁目や〜番地等はアラビア数字で入力して下さい(漢数字には未対応です)</span></p>
 <p><span class="text-danger">全国に対応いたしました。※問題がございましたらご報告頂きたくお願いいたします</span></p>
 <p>入力例1) 東京都千代田区丸の内１ー３</p>
 <p>入力例2) 神奈川県横浜市西区みなとみらい２ー２ー１(※政令指定都市の場合は、「市」及び「区」を含めてご入力下さい)</p>
 <!--<p><img src="/img/new.png" />-15.10.05- ご住所の入力補完に対応しました</p>-->
 </span>
</div>
<?php echo $this->Form->create(null, array("url" => "searchAddress#result", "type" => "post", "name"=>"form", "id"=>"registForm") ) ?>

<div class="well bs-component">
 <a name="result"></a>
 <div class="form-group">
	 <label class="control-label" for="inputLarge">ご住所</label>
	 <?php print $this->Form->text("SearchTaxOfficeAddress.address_name", array("value" => (isset($address_name) ? $address_name : "" ), "class" => "form-control input-sm", "id" => "address_name", "maxlength" => 50));?>
 </div>
 <div class="from-group">
	 <button type="button" class="btn btn-default" onclick="$(form).submit()">検索</button>
	 <!--<span id="bt_mylocation" class="btn btn-default" style="display:none">現在地から検索</span>-->
 </div>
</div>
<?php if(isset($master_tax_office) && count($master_tax_office) != 0) { ?>
<div class="alt-table-responsive">
	<?php print $this->element("paginator_element") ?>

  <table class="table">
		<tr>
			<th class="th_name">名前</th>
			<th class="th_address_no">〒</th>
			<th class="th_address">住所</th>
			<th class="th_tel">電話番号</th>
			<th class="th_zaimu">税務署番号</th>
			<th class="th_tax_offices">管轄</th>
		</tr>
		
		<?php for($i = 0; $i < count($master_tax_office); $i++) { ?>
		<tr>
			<td class="td_name"><span class="map" map_link_id="<?php print $master_tax_office[$i]["MasterTaxOffice"]["id"] ?>" ></span><?php print $master_tax_office[$i]["MasterTaxOffice"]["name"] ?></td>
			<td class="td_address_no"><?php print $master_tax_office[$i]["MasterTaxOffice"]["address_no"] ?> </td> 
			<td class="td_address"><a map_link_id="<?php print $master_tax_office[$i]["MasterTaxOffice"]["id"] ?>" href="https://maps.google.co.jp/maps?q=
<?php print urlencode($master_tax_office[$i]["MasterTaxOffice"]["prefecture"]
. $master_tax_office[$i]["MasterTaxOffice"]["address1"])?>" target="_blank"><?php print $master_tax_office[$i]["MasterTaxOffice"]["prefecture"]. $master_tax_office[$i]["MasterTaxOffice"]["address1"] ?></a></td>
			<td class="td_tel"><?php print $master_tax_office[$i]["MasterTaxOffice"]["tel"] ?></td>
			<td class="td_zaimu"><?php print $master_tax_office[$i]["MasterTaxOffice"]["zeimu_no"] ?></td>
			<td class="td_tax_offices">
			<?php if(isset($tax_offices[$master_tax_office[$i]["MasterTaxOffice"]["id"]])) { ?>
				<?php for($j = 0; $j < count($tax_offices[$master_tax_office[$i]["MasterTaxOffice"]["id"]]); $j++) { ?>
<a href="/search/search_detail/<?php print $tax_offices[$master_tax_office[$i]["MasterTaxOffice"]["id"]][$j]["id"] ?>.html#result">
					<span class="label label-primary"><?php print (empty($tax_offices[$master_tax_office[$i]["MasterTaxOffice"]["id"]][$j]["address_name"]) ? $tax_offices[$master_tax_office[$i]["MasterTaxOffice"]["id"]][$j]["city_name"] : $tax_offices[$master_tax_office[$i]["MasterTaxOffice"]["id"]][$j]["address_name"]) ?></span></a>
					<?php if( ($j + 1) % 4 == 0) { ?><br /><?php } ?>
				<?php } ?>
			<?php } ?>
			</td>
		</tr>
		<?php } ?>
  </table>
	<?php print $this->element("paginator_element") ?> 
</div>

<?php } else if($this->action != "index") { ?>
<div class="alert alert-danger">
検索結果が0件でした
</div>

<?php  if(isset($complete_data) && count($complete_data) != 0) { ?>
<p class="bg-primary">もしかして？</p>
<div class="list-group">
	<?php for($i = 0; $i < count($complete_data); $i++) { ?>	
	<a class="list-group-item" href="#"><?php print $complete_data[$i] ?></a>
	<?php } ?>
</div>
<?php } ?>

<?php } ?>
<?php echo $this->Form->end() ?>
