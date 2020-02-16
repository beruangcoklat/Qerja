<div id="info-gaji">
	<div id="info-gaji-header">
		<p>Informasi Gaji Pilihan</p>	
		<hr>
	</div>

	<company-info-gaji
		v-for="i in gajiDatas"
		v-bind:data="i"
	></company-info-gaji>

	<div id="info-gaji-footer">
		<hr>
		<p
			v-on:click="gotoGaji()"
		>Lihat semua gaji</p>
	</div>
	
</div>
