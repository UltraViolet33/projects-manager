let projects = [];

const tableProjectsBody = document.querySelector("#table-body");

const categoriesFilter = document.querySelector("#form-categories-select");

const statusFilter = document.querySelector("#form-status-select");

categoriesFilter.addEventListener("change", () => {
  getProjectsByCategoryAndStatus(categoriesFilter.value, statusFilter.value);
});

statusFilter.addEventListener("change", () => {
  getProjectsByCategoryAndStatus(categoriesFilter.value, statusFilter.value);
});

const getProjectsByCategoryAndStatus = async (idCategory, status) => {
  console.log(idCategory);
  console.log(status);
  if (status == "all" && idCategory == "all") {
    getAllProjects();
    return;
  }

  let url = "";

  if (status == "all") {
    url = `/api/projects/category?id=${idCategory}`;
  }

  if (idCategory == "all") {
    console.log("ok");
    url = `/api/projects/status?status=${status}`;
  }

  if (idCategory !== "all" && status !== "all") {
    url = `/api/projects/category?id=${idCategory}&status=${status}`;
  }

  try {
    const response = await fetch(url);
    projects = await response.json();
    getProjectsTable(projects);
  } catch (error) {
    console.log(error);
  }
};

const getAllProjects = async () => {
  const url = `/api/projects/all`;

  try {
    const response = await fetch(url);
    projects = await response.json();
    getProjectsTable(projects);
  } catch (error) {
    console.log(error);
  }
};

// getAllProjects();

const getProjectsTable = projects => {
  let htmlTable = projects.map(project => {
    let html = "";
    html = "<tr>";
    html += `<th scope="row">${project.id_project}</th>`;
    html += `<td>${project.name}</td>`;
    html += `<td>${project.created_at}</td>`;
    html += `<td><a href="/projects/details?id=${project.id_project}" class="btn btn-primary">Détails</a></td>`;
    html += "</tr>";
    return html;
  });
  tableProjectsBody.innerHTML = htmlTable.join("");
};

console.log(statusFilter.value);
getProjectsByCategoryAndStatus(categoriesFilter.value, statusFilter.value);
