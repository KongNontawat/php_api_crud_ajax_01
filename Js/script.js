$(document).ready(function () {
	getPlayers();
	$(".toast-message").hide();
	$(".toast-message").css('background-color', '#CFE2FF');
	
	$(document).on("click", "#addnewbtn", (e) => {
		e.preventDefault();
		$("#add_form")[0].reset();
		$("#userid").val("");
	});

	$(document).on("submit", "#add_form", (event) => {
		event.preventDefault();
		let form = $("#add_form");
		let form_data = new FormData(form[0]);
		let alert_message =
			$("#userid").val().length > 0
				? "<b>Update Successfully!!</b>"
				: "<b>Add Player Successfully!!</b>";
		$.ajax({
			url: "/php_api_crud_ajax_01/ajax.php",
			type: "POST",
			datatype: "json",
			data: form_data,
			processData: false,
			contentType: false,
			success: (resp) => {
				if (resp) {
					$("#userModal").modal("hide");
					form[0].reset();
					getPlayers();
					$('.toast-message').fadeIn().delay(3000).fadeOut();
					$(".toast-body").html(alert_message);
			}},
			error: () => {
				console.error("Oops! something went wrong!");
			},
		});
	});

	$(document).on("click", "ul.pagination li a", (e) => {
		e.preventDefault();
	});

	$(document).on("click", "a.edituser", (e) => {
		e.preventDefault();
	});

	$(document).on("click", "a.deleteuser", (e) => {
		e.preventDefault();
	});

	$(document).on("click", "a.profile", (e) => {
		e.preventDefault();
	});

	$("#searchinput").on("keyup", (e) => {
		e.preventDefault();
		const searchText = $("#searchinput").val();
		if (searchText.length > 1) {
			$.ajax({
				url: "/php_api_crud_ajax_01/ajax.php",
				type: "GET",
				dataType: "json",
				data: { searchQuery: searchText, action: "search" },
				success: function (players) {
					if (players) {
						var playersList = "";
						$.each(players, function (index, player) {
							playersList += getPlayerRow(player);
						});
						$("#userstable tbody").html(playersList);
						$("#pagination").hide();
					}
				},
				error: () => {
					console.error("Oops! something went wrong!");
				},
			});
		} else {
			getPlayers();
			$("#pagination").show();
		}
	});
});

function getPlayers() {
	var pageno = $("#currentpage").val();
	$.ajax({
		url: "/php_api_crud_ajax_01/ajax.php",
		type: "GET",
		dataType: "json",
		data: { page: pageno, action: "getusers" },
		success: function (rows) {
			if (rows.players) {
				var playersList = "";
				$.each(rows.players, function (index, player) {
					playersList += getPlayerRow(player);
				});
				$("#userstable tbody").html(playersList);
				let totalPlayers = rows.count;
				let total_page = Math.ceil(parseInt(totalPlayers) / 4);
				const current_page = $("#currentpage").val();
				pagination(total_page, current_page);
			}
		},
		error: () => {
			console.error("Oops! something went wrong!");
		},
	});
}

function getPlayerRow(player) {
	var playerRow = "";
	if (player) {
		const userphoto = player.photo ? player.photo : "default.png";
		playerRow = `<tr>
      <td class="align-middle"><img src="Image/uploads/${userphoto}" class="img-thumbnail rounded float-left"></td>
      <td class="align-middle">${player.pname}</td>
      <td class="align-middle">${player.email}</td>
      <td class="align-middle">${player.phone}</td>
      <td class="align-middle">
        <a href="#" class="btn btn-success mr-3 profile" onclick="profileUser(this)" data-bs-toggle="modal" data-bs-target="#userViewModal" title="Prfile"
          data-id="${player.id}"><i class="fa fa-address-card" aria-hidden="true"></i></a>
        <a href="#" class="btn btn-warning mr-3 edituser" data-bs-toggle="modal" data-bs-target="#userModal" title="Edit"
          data-id="${player.id}" onclick="editUser(this)"><i class="fa fa-edit fa-lg text-white"></i></i></a>
        <a href="#" class="btn btn-danger deleteuser" onclick="deleteUser(this)" data-userid="14" title="Delete" data-id="${player.id}"><i
            class="fa fa-trash fa-lg"></i></a>
      </td>
    </tr>`;
	}
	return playerRow;
}

function pagination(total_pages, current_page) {
	var pageList = "";
	if (total_pages > 1) {
		current_page = parseInt(current_page);
		pageList += `<ul class="pagination justify-content-center pt-4">`;
		const PrevClass = current_page == 1 ? " disabled" : "";
		pageList += `<li class="page-item${PrevClass}"><a class="page-link" href="#" onclick="pagination_click(this)" data-page="${
			current_page - 1
		}">Previous</a></li>`;
		for (let p = 1; p <= total_pages; p++) {
			const activeClass = current_page == p ? " active" : "";
			pageList += `<li class="page-item${activeClass}"><a class="page-link" href="#" onclick="pagination_click(this)" data-page="${p}">${p}</a></li>`;
		}
		const NextClass = current_page == total_pages ? " disabled" : "";
		pageList += `<li class="page-item${NextClass}"><a class="page-link" href="#" onclick="pagination_click(this)" data-page="${
			current_page + 1
		}">Next</a></li>`;
		pageList += `</ul>`;
	}
	$("#pagination").html(pageList);
}

function pagination_click(el) {
	var element = $(this);
	dataPage = $(el).attr("data-page");
	$("#currentpage").val(dataPage);
	getPlayers();
	// console.log(el);
	element.parent().siblings().removeClass("active");
	element.parent().addClass("active");
}

function editUser(el) {
	var element = $(this);
	dataID = $(el).attr("data-id");

	$.ajax({
		url: "/php_api_crud_ajax_01/ajax.php",
		type: "GET",
		dataType: "json",
		data: { id: dataID, action: "getuser" },
		success: function (player) {
			if (player) {
				$("#username").val(player.pname);
				$("#email").val(player.email);
				$("#phone").val(player.phone);
				$("#userid").val(player.id);
			}
		},
		error: () => {
			console.error("Oops! something went wrong!");
		},
	});
}

function deleteUser(el) {
	dataID = $(el).attr("data-id");
	if (confirm("Are you sure want tot delete this?")) {
		$.ajax({
			url: "/php_api_crud_ajax_01/ajax.php",
			type: "GET",
			dataType: "json",
			data: { id: dataID, action: "deleteuser" },
			success: function (resp) {
				if (resp.deleted == 1) {
					getPlayers();
					$('.toast-message').fadeIn().delay(3000).fadeOut();
					$(".toast-body").html('<b>Deleted Player Successfully!!</b>');
				}
			},
			error: () => {
				console.error("Oops! something went wrong!");
			},
		});
	}
}

function profileUser(el) {
	dataID = $(el).attr("data-id");

	$.ajax({
		url: "/php_api_crud_ajax_01/ajax.php",
		type: "GET",
		dataType: "json",
		data: { id: dataID, action: "getuser" },
		success: function (player) {
			if (player) {
				const userphoto = player.photo ? player.photo : "default.png";
				const profile = `
				<div class="row">
          <div class="col-sm-6 col-md-4">
            <img src="Image/uploads/${userphoto}" class="rounded responsive" />
          </div>
          <div class="col-sm-6 col-md-8">
            <h4 class="text-primary">${player.pname}</h4>
            <p class="text-secondary">
              <i class="fa fa-envelope-o" aria-hidden="true"></i> ${player.email}
              <br />
              <i class="fa fa-phone" aria-hidden="true"></i> ${player.phone}
            </p>
          </div>
        </div>
				`;
				$("#profile").html(profile);
			}
		},
		error: () => {
			console.error("Oops! something went wrong!");
		},
	});
}
