export default class MotorkApi {
    constructor(baseUrl = '/api/v1') {
      this.baseUrl = baseUrl;
    }

    async fetchJson(url, options = {}) {
      const response = await fetch(url, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          ...options.headers,
        },
        ...options,
      });
      if (!response.ok) {
        const error = await response.json();
        throw new Error(error.message || 'Erreur API');
      }
      return await response.json();
    }

    // VEHICLES

    async getMakes() {
        return await this.fetchJson(`${this.baseUrl}/makes`);
    }

    async getFacets(type) {
        return await this.fetchJson(`${this.baseUrl}/facets/${type}`);
    }

    async getModels(make) {
      return await this.fetchJson(`${this.baseUrl}/models/${make}`);
    }

    async getSubmodels(model) {
      return await this.fetchJson(`${this.baseUrl}/submodels/${model}`);
    }

    async getVersions(submodel) {
      return await this.fetchJson(`${this.baseUrl}/versions/${submodel}`);
    }

    async getVersionDetails(versionId) {
      return await this.fetchJson(`${this.baseUrl}/version/${versionId}`);
    }

    // CONFIGURATION
    async getEquipments(vehicleId) {
      return await this.fetchJson(`${this.baseUrl}/equipments/${vehicleId}`);
    }

    async addEquipment(vehicleId, idEquipment, config = '') {
      return await this.fetchJson(`${this.baseUrl}/equipments/${vehicleId}/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ vehicleId, idEquipment, config }),
      });
    }

    async removeEquipment(vehicleId, idEquipment, config = '') {
      return await this.fetchJson(`${this.baseUrl}/equipments/${vehicleId}/remove`, {
        method: 'POST',
        body: JSON.stringify({ vehicleId, idEquipment, config }),
      });
    }

    // COMPARISON

    async compareVehicles(versionIds) {
      return await this.fetchJson(`${this.baseUrl}/compare`, {
        method: 'POST',
        body: JSON.stringify({ versionIds }),
      });
    }

    // QUOTE

    async requestQuote(configuration) {
      return await this.fetchJson(`${this.baseUrl}/quote`, {
        method: 'POST',
        body: JSON.stringify(configuration),
      });
    }
  }
