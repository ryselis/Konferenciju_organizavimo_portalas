function addEquipmentField() {
	var equipmentDiv = document.getElementById('equipment');
	var existingInputs = equipmentDiv.childNodes;
	var newEquipmentInputId = existingInputs.length;
	var html = '<div><label>Pavadinimas</label><input name="equipment_' + newEquipmentInputId + '" /></div>';
	if (newEquipmentInputId > 0) {
		var lastInput = existingInputs[existingInputs.length - 1];
		lastInput.insertAfter('afterend', html);
	}
	else{
		equipmentDiv.innerHTML = html;
	}
}
