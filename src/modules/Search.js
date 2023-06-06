import $ from "jquery";

class Search {
  isOpen = false;
  searchTimer = null;

  constructor() {
    this.addSearchHTML();

    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $(".search-term");
    this.searchResults = $(".search-overlay__results");
    this.isSpinnerVisible = false;
    this.previousValue = "";

    this.events();
  }

  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));

    $(document).on("keydown", this.keypressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  typingLogic(e) {
    if (this.searchField.val().trim() != this.previousValue) {
      clearTimeout(this.searchTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.searchResults.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }

        this.searchTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.searchResults.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val().trim();
  }

  async getResults() {
    const response = await $.getJSON(
      universityData.root_url +
        "/wp-json/university/v1/search?term=" +
        this.searchField.val().trim()
    );

    this.searchResults.html(`
  <div class="row">
      <div class="one-third">
        <h2 class="search-overlay__section-title">General Information</h2>
        ${
          response.generalInfo.length == 0
            ? `<p>No general information matches that search.</p>`
            : `<ul class="link-list min-list">
                ${response.generalInfo
                  .map((item) => {
                    return `<li>
                              <a href="${item.link}">${item.title}</a> by ${item.authorName}
                            </li>`;
                  })
                  .join("")}
              </ul>`
        }
      </div>
      <div class="one-third">
        <h2 class="search-overlay__section-title">Programs</h2>
        ${
          response.programs.length == 0
            ? `<p>No programs matches that search.</p>`
            : `<ul class="link-list min-list">
                ${response.programs
                  .map((item) => {
                    return `<li>
                              <a href="${item.link}">${item.title}</a>
                            </li>`;
                  })
                  .join("")}
              </ul>`
        }
        <h2 class="search-overlay__section-title">Professors</h2>
        ${
          response.professors.length == 0
            ? `<p>No professors matches that search.</p>`
            : `<ul class="professor-cards">
                ${response.professors
                  .map((item) => {
                    return `
            <li class="professor-card__list-item">
                <a href="${item.link}" class="professor-card">
                    <img class="professor-card__image" src="${item.thumb}" />
                    <span class="professor-card__name">${item.title}</span>
                </a>
            </li>
                    `;
                  })
                  .join("")}
              </ul>`
        }
      </div>
      <div class="one-third">
        <h2 class="search-overlay__section-title">Campuses</h2>
        ${
          response.campuses.length == 0
            ? `<p>No campuses matches that search.</p>`
            : `<ul class="link-list min-list">
                ${response.campuses
                  .map((item) => {
                    return `<li>
                              <a href="${item.link}">${item.title}</a>
                            </li>`;
                  })
                  .join("")}
              </ul>`
        }
        <h2 class="search-overlay__section-title">Events</h2>
        ${
          response.events.length == 0
            ? `<p>No events matches that search.</p>`
            : `${response.events
                .map((item) => {
                  return `<div class="event-summary">
                              <a class="event-summary__date event-summary__date--beige t-center" href="#">
                                  <span class="event-summary__month">${item.month}</span>
                                  <span class="event-summary__day">${item.day}</span>
                              </a>
                              <div class="event-summary__content">
                                  <h5 class="event-summary__title headline headline--tiny"><a href="${item.link}">${item.title}</a></h5>
                                  <p>${item.description}<a href="${item.link}" class="nu gray">Read more</a></p>
                              </div>
                          </div>`;
                })
                .join("")}`
        }
      </div>
  </div>  
  `);

    clearTimeout(this.searchTimer);
    this.isSpinnerVisible = false;
  }

  keypressDispatcher(e) {
    const code = e.keyCode || e.which;
    if (code == 83 && !this.isOpen && !$("input, textarea").is(":focus")) {
      this.openOverlay();
    } else if (code == 27 && this.isOpen) {
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.isOpen = true;
    setTimeout(() => {
      this.searchField.focus();
    }, 500);
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOpen = false;
  }

  addSearchHTML() {
    $("body").append(
      `<div class="search-overlay">
          <div class="search-overlay__top">
              <div class="container">
                  <i class="fa fa-search search-overlay__icon" aria-hidden="hidden"></i>
                  <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off" />
                  <i class="fa fa-window-close search-overlay__close" aria-hidden="hidden"></i>
              </div>
          </div>
          <div class="container">
              <div class="search-overlay__results">  
              </div>
          </div>
      </div>`
    );
  }
}

export default Search;
