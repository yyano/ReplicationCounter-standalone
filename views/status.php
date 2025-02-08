<div class="pl-4">
    <p class="py-2">inputValue: <?= isset($request['inputValue']) ? htmlspecialchars($request['inputValue']) : '' ?></p>
    <p class="py-2">prefix: <?= isset($request['prefix']) ? htmlspecialchars($request['prefix']) : '' ?></p> 
    <p class="py-2">counter: <?= isset($request['counter']) ? htmlspecialchars($request['counter']) : '' ?></p>
    <p class="py-2">printer: <?= $model ?? '' ?>( <?= $lpPath ?? '' ?> )</p>
</div>