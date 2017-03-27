<div class="rated">
	<div class="rating-note event-note">Средняя оценка {{ $sense }}</div>
	<div class="stars">
		<input value="1" type="radio" name="star" class="star-1" id="star-1" />
		<label class="star-1" for="star-1">1</label>
		<input value="2" type="radio" name="star" class="star-2" id="star-2" />
		<label class="star-2" for="star-2">2</label>
		<input value="3" type="radio" name="star" class="star-3" id="star-3" />
		<label class="star-3" for="star-3">3</label>
		<input value="4" type="radio" name="star" class="star-4" id="star-4" />
		<label class="star-4" for="star-4">4</label>
		<input value="5" type="radio" name="star" class="star-5" id="star-5" />
		<label class="star-5" for="star-5">5</label>
		<span <?php $rating ? print('style="width: ' . intval($rating) * 20 . '%;"') : ''; ?>></span>
	</div>
</div>