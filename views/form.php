<form action="/" method="POST" class="form form-inline text-3xl">
  <div class="form-inline m-2">
    <input type="text" name="inputValue" placeholder="string..." size="40" class="form-control border appearance-none border-blue-500 rounded bg-white p-2" autofocus>
    <button type="submit" id="print" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
      PRINT
    </button>
  </div>

  <div class="form-inline m-2">
    <label>Nex count:</label>
    <input type="text" name="prefix" placeholder="e.g. AA00" value="<?= $prefix ?? '' ?>" size="6" maxlength="4" autocapitalize="characters" class="form-control border appearance-none border-blue-500 rounded bg-white p-2">
    <input type="number" name="counter" value="<?= sprintf("%04d", $counter?? 0) ?>" size="6" class="form-control border appearance-none border-blue-500 rounded bg-white p-2">
  </div>

</form>
