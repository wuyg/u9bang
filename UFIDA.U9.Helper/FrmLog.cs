using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using log4net;
using System.Threading;
using log4net.Core;

namespace UFIDA.U9.Helper
{
    public partial class FrmLog : Form
    {
        private static readonly ILog log = LogManager.GetLogger(typeof(FrmLog));
        private bool logWatching = true;
        private log4net.Appender.MemoryAppender logger;
        private Thread logWatcher;
        public FrmLog()
        {
            InitializeComponent();
        }

        private void FrmLog_Load(object sender, EventArgs e)
        {
            this.FormClosing += new FormClosingEventHandler(FrmLog_FormClosing);
            logger = new log4net.Appender.MemoryAppender();
            log4net.Config.BasicConfigurator.Configure(logger);

            logWatcher = new Thread(new ThreadStart(LogWatcher));
            logWatcher.Start();
        }

        void FrmLog_FormClosing(object sender, FormClosingEventArgs e)
        {
            logWatching = false;
            logWatcher.Join();
        }
        delegate void DelOneStr(string log);
        private void AppendLog(string text)
        {
            if (txtLog.InvokeRequired)
            {
                DelOneStr d = new DelOneStr(AppendLog);
                txtLog.Invoke(d, text);
            }
            else
            {
                StringBuilder sb = new StringBuilder();
                if (txtLog.Lines.Length > 90)
                {
                    sb = new StringBuilder(txtLog.Text);
                    sb.Remove(0, txtLog.Text.IndexOf("\r", 3000) + 2);
                    sb.Append(text);
                    txtLog.Clear();
                    txtLog.AppendText(sb.ToString());
                }
                else
                {
                    txtLog.AppendText(text);
                }
            }
        }
        private void LogWatcher()
        {
            while (logWatching)
            {
                LoggingEvent[] events = logger.GetEvents();
                if (events != null && events.Length > 0)
                {
                    logger.Clear();
                    foreach (LoggingEvent ev in events)
                    {
                        string line = ev.LoggerName + ":" + ev.RenderedMessage + "\r\n";
                        AppendLog(line);
                    }
                }
                Thread.Sleep(500);
            }
        }
    }
}
