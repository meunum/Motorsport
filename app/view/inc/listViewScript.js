function editEntity(entityId, entityType) 
{
  var actionInput = document.getElementById("actionInput");
  actionInput.setAttribute("value", "Edit" + entityType);
  var idInput = document.getElementById("idInput");
  idInput.setAttribute("value", entityId);
}

function confirmDeleteEntity(entityId, entityType, entityName, entityTitle) 
{
  var actionInput = document.getElementById("actionInput");
  var idInput = document.getElementById("idInput");
  if (confirm(`Möchtest Du ${entityTitle} "${entityName}" löschen?`)) 
  {
    actionInput.setAttribute("value", "Delete" + entityType);
    idInput.setAttribute("value", entityId);
  } 
  else 
  {
    actionInput.setAttribute("value", entityType + "List");
    idInput.setAttribute("value", "");
  }
}