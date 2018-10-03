class CitySelection {
  constructor() {
    this.country = document.querySelector('#dashboard-body #country_select');
    this.ListCountries();
    this.state = document.querySelector('#dashboard-body #state_select');
    this.city = document.querySelector('#dashboard-body #city_select');

    this.countryValue = "";
  }

  ListCountries(){
    this.GetData('').then(countryName => {
      for (var i = 0; i < 219; i++) {
        this.country.innerHTML += `<option value="${countryName[i].country_name}">${countryName[i].country_name}</option>`;
      }
    });
    setTimeout(() =>{
      let currentCountry = this.country.value;
      let currentState = this.state.value;
      this.ListStates(currentCountry);
      this.ListCities(currentState);
    }, 1000);
  }

  ListStates(value) {
    if(value != ""){
      if(this.state.innerHTML == `<option value="">Select your state</option>`){
        this.state.innerHTML = `<option value="">Select your state</option>`;
      }
      this.countryValue = value;
      this.state.disabled = false;
      let listOfStates = [];
      this.GetData(`?country=${value}`).then(statesName => {
        for (var i = 0; i < statesName.details.regionalBlocs.length; i++) {
          listOfStates.push(statesName.details.regionalBlocs[i].state_name);
        }
        listOfStates.sort();
        listOfStates.forEach((list) =>{
          this.state.innerHTML += `<option value="${list}">${list}</option>`;
        })

      });
    }else{
      this.state.disabled = true;
      this.state.innerHTML = `<option value="">Select your state</option>`;
    }
  }

  ListCities(value) {
    if(this.state.innerHTML == `<option value="">Select your city</option>`){
      this.state.innerHTML = `<option value="">Select your city</option>`;
    }
    let cities = [];
    if(value != ""){
      this.city.disabled = false;
      this.GetData(`?country=${this.countryValue}&state=${value}`).then(citiesName => {
        for (var i = 0; i < Object.keys(citiesName).length-1; i++) {
          // this.city.innerHTML += `<option value="${citiesName[i].city_name}">${citiesName[i].city_name}</option>`;
          cities.push(citiesName[i].city_name);
        }
        cityList = cities;
        cityList.sort();
        for (var i = 0; i < cityList.length; i++) {
          this.city.innerHTML += `<option value="${cityList[i]}">${cityList[i]}</option>`;
        }
      });
    }else{
      this.city.disabled = true;
      this.city.innerHTML = `<option value="">Select your state</option>`;
    }
  }

  async GetData(tags){
    //waits for the fetch request
    const response = await fetch(`https://cors-anywhere.herokuapp.com/https://geodata.solutions/restapi${tags}`);

    //only proceeds once its resolved
    const data = await response.json();

    //only proceeds once the second promise is resolved
    return data;
  }
}

var cityList = [];
let citySelection = new CitySelection;
