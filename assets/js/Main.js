import React, { Component } from 'react';
import County from './County';
import NewCity from './NewCity';
import CityLister from './CityLister';
import $ from 'jquery';

class Main extends Component {
    constructor(props) {
        super(props);
        this.state = {
            counties: [],
            countyName: null,
            cities: [],
            editedCityId: null,
            selectedCountyId: null
        };

        this.handleCountyChange = this.handleCountyChange.bind(this);
        this.handleCreateCity = this.handleCreateCity.bind(this);
        this.handleCityClick = this.handleCityClick.bind(this);
        this.handleCityDelete = this.handleCityDelete.bind(this);
        this.handleCancel = this.handleCancel.bind(this);
        this.handleCityUpdate = this.handleCityUpdate.bind(this);
    }

    componentDidMount() {
        this.getCounties();
    }

    getCounties() {
        const env = this;

        $.get('/counties', function(response) {
            const state = env.state;
            state.counties = response;
            env.setState({ state });
        });
    }

    handleCountyChange(event) {
        this.saveCountyId(event);

        if (this.state.selectedCountyId > 0) {
            this.loadCities();
            this.loadCountyName();
        }
    }

    saveCountyId(event) {
        const state = this.state;
        state.selectedCountyId = event.target.value;
        this.setState({ state });
    }

    loadCities() {
        const env = this;

        $.get('/cities/county/' + env.state.selectedCountyId, function(response) {
            const state = env.state;
            state.cities = response;
            env.setState({ state });
        });
    }

    loadCountyName() {
        const env = this;

        $.get('/counties/' + env.state.selectedCountyId, function(response) {
            const state = env.state;
            state.countyName = response.name;
            env.setState({ state });
        });
    }

    handleCreateCity(event) {
        event.preventDefault();
        const env = this;
        const selectedCountyId = env.state.selectedCountyId;
        const newCityName = $('#newCityName');

        $.post('/cities', {countyId: selectedCountyId, name: newCityName.val()}, function() {
            newCityName.val('');
            env.loadCities();
            alert('Sikeres mentés!');
        }).fail(function(jqXHR) {
            alert(jqXHR.responseJSON.error.text);
        });
    }

    handleCityClick(cityId) {
        const state = this.state;
        state.editedCityId = cityId;
        this.setState({ state });
    }

    handleCityDelete(event) {
        event.preventDefault();
        const env = this;
        const cityId = this.state.editedCityId;

        $.ajax({
            url: '/cities/' + cityId,
            type: 'DELETE'
        }).done(function() {
            env.loadCities();
            alert('Sikeres törlés!');
        }).fail(function() {
            alert('Törlés sikertelen! Már törölve?');
        });
    }

    handleCancel(event) {
        event.preventDefault();
        this.clearEdited();
        this.loadCities();
    }

    clearEdited() {
        const state = this.state;
        state.editedCityId = null;
        this.setState({ state });
    }

    handleCityUpdate(event) {
        event.preventDefault();
        const env = this;
        const cityId = this.state.editedCityId;
        const cityName = $('#editCityName').val();

        $.ajax({
            url: '/cities/' + cityId,
            data: {name: cityName},
            type: 'PUT',
        }).done(function() {
            env.clearEdited();
            env.loadCities();
            alert('Sikeres módosítás!');
        }).fail(function(jqXHR) {
            alert(jqXHR.responseJSON.error.text);
        });
    }

    render() {
        return (
            <div className="container mt-4">
                <div className="row no-gutters">
                    <div className="col"></div>
                    <div className="col-4">
                        <County counties={this.state.counties} handleCountyChange={this.handleCountyChange} />
                        {this.state.selectedCountyId > 0 && <NewCity handleCreateCity={this.handleCreateCity} />}
                    </div>
                    <div className="col-6">
                        {this.state.selectedCountyId > 0 &&
                        <CityLister cities={this.state.cities} countyName={this.state.countyName}
                        editedCityId={this.state.editedCityId} handleCityClick={this.handleCityClick}
                        handleCityDelete={this.handleCityDelete} handleCancel={this.handleCancel}
                        handleCityUpdate={this.handleCityUpdate} />}
                    </div>
                    <div className="col"></div>
                </div>
            </div>
        );
    }
}

export default Main;
