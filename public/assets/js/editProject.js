const btn_status_div = document.querySelector("#btn-toggle-status");

let project;

let btnPriority;
let btnStatus;
let btnPortfolio;

const displayBtns = project => {
  btnPriority = getBtnProperty(project, "priority");
  btnStatus = getBtnProperty(project, "status");
  btnPortfolio = getBtnProperty(project, "portfolio");

  btn_status_div.appendChild(btnPriority);
  btn_status_div.appendChild(btnStatus);
  btn_status_div.appendChild(btnPortfolio);
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
    removeButtons();
    displayBtns(project);
  } catch (error) {
    console.log(error);
  }
};

const getBtnProperty = (project, property) => {
  switch (property) {
    case "priority":
      return project.priority
        ? createButton("btn-danger", "priority", "High")
        : createButton("btn-primary", "priority", "Low");
    case "status":
      return project.status
        ? createButton("btn-primary", "status", "Done")
        : createButton("btn-danger", "status", "In Progress");
    case "portfolio":
      return project.github_portfolio
        ? createButton("btn-primary", "github", "In Github Portfolio")
        : createButton("btn-primary", "github", "Not In Github Portfolio");
  }
};

const createButton = (className, id, textContent) => {
  const div_btn = document.createElement("div");
  div_btn.classList.add("m-2");
  const button = document.createElement("button");
  button.classList.add("btn");
  button.classList.add(className);
  button.setAttribute("id", id);
  button.addEventListener("click", () => toggle(button));
  button.textContent = textContent;
  div_btn.appendChild(button);
  return div_btn;
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

const removeButtons = () => {
  btn_status_div.removeChild(btnPriority);
  btn_status_div.removeChild(btnStatus);
  btn_status_div.removeChild(btnPortfolio);
};

const url = new URL(window.location.href);
const idProject = url.searchParams.get("id");
getProject(idProject);
