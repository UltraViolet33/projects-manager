let projects = [];

const tableProjectsBody = document.querySelector("#table-body");

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
    console.log(html);
    return html;
  });
  tableProjectsBody.innerHTML = htmlTable.join("");
};