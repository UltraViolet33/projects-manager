const btn_status_div = document.querySelector("#btn-toggle-status");

let project;

const displayBtns = project => {
  let buttonsHTML = "";
  buttonsHTML += getBtnStatus(project);
  buttonsHTML += getBtnPriority(project);
  buttonsHTML += getBtnGithubPortfolio(project);

  btn_status_div.innerHTML = buttonsHTML;
};

const toggle = el => {
  const idElement = el.getAttribute("id");
  switch (idElement) {
    case "status":
      project.status = !project.status;
      break;
    case "github":
      project.github_portfolio = !project.github_portfolio;
      break;
    case "priority":
      project.priority = !project.priority;
      break;
  }
  editProject(project);
};

const editProject = async project => {
  const url = `/api/projects/edit`;

  try {
    const response = await fetch(url, {
      method: "POST",
      body: JSON.stringify(project),
    });

    project = await response.json();

    displayBtns(project);
  } catch (error) {
    console.log(error);
  }
};

const getBtnPriority = project => {
  if (project.priority) {
    return "<button class='btn btn-danger' id='priority' onclick='toggle(this)' >High</button>";
  }
  return "<button class='btn btn-primary'  id='priority' onclick='toggle(this)'>Low</button>";
};

const getBtnStatus = project => {
  if (project.status) {
    return "<button class='btn btn-primary' id='status' onclick='toggle(this)'>Done</button>";
  }

  return "<button class='btn btn-primary' id='status' onclick='toggle(this)'>In Progress</button>";
};

const getBtnGithubPortfolio = project => {
  if (project.github_portfolio) {
    return "<button class='btn btn-primary' id='github' onclick='toggle(this)'>In github portfolio</button>";
  }

  return "<button class='btn btn-primary' id='github' onclick='toggle(this)'>Not in github portfolio</button>";
};

const getProject = async idProject => {
  const url = `/api/projects/single-project?id=${idProject}`;

  try {
    const response = await fetch(url);
    project = await response.json();

    displayBtns(project);
  } catch (error) {
    console.log(error);
  }
};

const url = new URL(window.location.href);
const idProject = url.searchParams.get("id");
getProject(idProject);
