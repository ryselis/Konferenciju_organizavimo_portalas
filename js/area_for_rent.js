function addEquipmentField() {
	var equipmentDiv = document.getElementById('equipment');
	var existingInputs = equipmentDiv.childNodes;
	var newEquipmentInputId = existingInputs.length;
	var html = '<div><div><label>Pavadinimas</label><input name="equipment_' + newEquipmentInputId + '" /></div><label>Kaina</label><input name="price_' + newEquipmentInputId + '" type="number" /><div></div></div>';
	if (newEquipmentInputId > 0) {
		var lastInput = existingInputs[existingInputs.length - 1];
		lastInput.insertAdjacentHTML('beforeEnd', html);
	} else {
		equipmentDiv.innerHTML = html;
	}
}
