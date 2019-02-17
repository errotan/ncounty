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
            selectedCountyId: null
        };

        this.handleCountyChange = this.handleCountyChange.bind(this);
        this.handleCreateCity = this.handleCreateCity.bind(this);
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
        const newCountyName = $('#newCountyName');

        $.post('/cities', {countyId: selectedCountyId, name: newCountyName.val()}, function() {
            newCountyName.val('');
            env.loadCities();
            alert('Sikeres mentés!');
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
                        <CityLister cities={this.state.cities} countyName={this.state.countyName} />}
                    </div>
                    <div className="col"></div>
                </div>
            </div>
        );
    }
}

export default Main;
