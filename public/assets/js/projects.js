let projects = [];

const tableProjectsBody = document.querySelector("#table-body");

const categoriesFilter = document.querySelector("#form-categories-select");

categoriesFilter.addEventListener("change", () => {
  getProjectsByCategory(categoriesFilter.value);
});

const getProjectsByCategory = async idCategory => {
  const url = `/api/projects/category?id=${idCategory}`;

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

getAllProjects();

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
