const btn_status_div = document.querySelector("#btn-toggle-status");

const displayBtns = (project) => {

    if(project.status)
    {
        
    }

};

const getProject = async  idProject => {
  const url = `/api/projects/single-project?id=${idProject}`;

  try {
    const response = await fetch(url);
    const project = await response.json();
    console.log(project);
    displayBtns(project);
  } catch (error) {
    console.log(error);
  }

};

getProject(26);
