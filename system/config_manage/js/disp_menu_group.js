$(document).ready(function(){
	
});

function test_tree(treeData){
	
	$("#menu_tree").dynatree({
		checkbox: true,
		selectMode: 3,
		children: treeData,
		onSelect: function(select, node) {
			var arr = node.tree.getSelectedNodes().join(" | ").split(" | ");
			var hidden = "";
			for(i=0;i<arr.length;i++){
				var arrId = arr[i].split(":");
				var id = arrId[0].replace("DynaTreeNode<c_id","").replace(">","").split(".");
				switch(id.length){
					case 1 : hidden += "<input name=\"menu["+id[0]+"]\" type=\"hidden\" value=\"1\">";  break;
					case 2 : hidden += "<input name=\"menu["+id[0]+"]["+id[1]+"]\" type=\"hidden\" value=\"1\">"; break;
					case 3 : hidden += "<input name=\"menu["+id[0]+"]["+id[1]+"]["+id[2]+"]\" type=\"hidden\" value=\"1\">"; break;
					case 4 : hidden += "<input name=\"menu["+id[0]+"]["+id[1]+"]["+id[2]+"]["+id[3]+"]\" type=\"hidden\" value=\"1\">"; break;
					case 5 : hidden += "<input name=\"menu["+id[0]+"]["+id[1]+"]["+id[2]+"]["+id[3]+"]["+id[4]+"]\" type=\"hidden\" value=\"1\">"; break;
					case 6 : hidden += "<input name=\"menu["+id[0]+"]["+id[1]+"]["+id[2]+"]["+id[3]+"]["+id[4]+"]["+id[5]+"]\" type=\"hidden\" value=\"1\">"; break;
				}
			}
			$("#allHidden").html(hidden);
		}
	});
}