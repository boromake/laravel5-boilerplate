@if (Session::has('sweet_alert.alert'))
	<script type="text/javascript">
		swal({!! Session::get('sweet_alert.alert') !!});
	</script>
	<?php Session::forget('sweet_alert'); ?>
@endif