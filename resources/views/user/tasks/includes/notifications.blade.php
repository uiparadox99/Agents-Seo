<?php if (Session::has("success-msg")): ?>
<script type="text/javascript">
    toastr["success"]('<?php echo Session::get("success-msg"); ?>');
</script>
<?php endif ?>

<!--Error message template-->
<?php if (Session::has("error-msg")): ?>
<script type="text/javascript">
    toastr["error"]('<?php echo Session::get("error-msg"); ?>');
</script>
<?php endif ?>

<?php 
if(Session::has("success-msg")):
    Session::remove("success-msg");
endif;

if(Session::has("error-msg")):
    Session::remove("error-msg");
endif;
?>