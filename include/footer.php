<?php if (isset($ErrMsg) && !empty($ErrMsg)) { ?>
<script type="text/javascript">
    alert('<?php echo $ErrMsg; ?>');
</script>
<?php } ?>
<?php if (!isset($Program)) $Program = '網頁程設'; ?>
<div style="width:100%;text-align:center;background:#ffe6e6;margin-top:8px;
font-weight:bold;font-size:18px;color:#5e595c;padding:2px 0;">
<?php echo $Program; ?> 測驗與實作網站
</div>
