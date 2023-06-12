## Laravel Prometheus demo app

This repo contains a demo app for [Laravel Prometheus](https://spatie.be/docs/laravel-prometheus). 

You'll find more info on how to use this app in [this blog post](https://freek.dev/2507-visualising-laravel-and-horizon-metrics-using-prometheus-and-grafana?preview_secret=6PxM6bZlbv).

The demo application is vanilla Laravel app with:

- Laravel Prometheus installed
- Laravel Horizon installed with 4 queues configured
- An artisan command `app:dispatch-jobs` to dispatch dummy jobs

## Installation

Clone this repo and run `composer install`.

You should [install the Grafana agent via brew](https://grafana.com/docs/agent/latest/static/set-up/install-agent-macos/) and not start it as a daemon (we'll start it manually later on).

The agent config should be saved at `/opt/homebrew/etc/grafana-agent/config.yml`

```yaml
metrics:
  wal_directory: /Users/<your-user-name>/dev/code/grafana-wal
  global:
    scrape_interval: 10s
  configs:
  - name: hosted-prometheus
    scrape_configs:
    - job_name: laravel
      scrape_interval: 10s
      metrics_path: /prometheus
      static_configs:
        - targets: ['prometheus-demo-app.test']
    remote_write:
      - url: <your-grafana-com-prometheus-url>
        basic_auth:
          username: <your-grafana-prometheus-username>
          password: <your-grafana-prometheus-password>
```

## Usage

1. Start horizon using `php artisan horizon`.
2. Start the grafana agent using `composer start-agent`.
3. Dispatch jobs using `php artisan app:dispatch-jobs`.

Metrics will be sent to Grafana.com

Agent log is at `/opt/homebrew/var/log/grafana-agent.log`
Agent error log is at `/opt/homebrew/var/log/grafana-agent.err.log`
