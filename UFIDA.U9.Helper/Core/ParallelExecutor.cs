using System;
using System.Collections.Generic;
using System.Threading;
using log4net;
namespace UFIDA.U9.Helper
{
    public class ParallelExecutor
    {
        private static readonly ILog log = LogManager.GetLogger(typeof(ParallelExecutor));
        public delegate IEnumerable<IParallelCommand> CommandTaskHandler();        
        public ParallelExecutor(int ThreadCount)
        {
            int maxCPU = IntPtr.Size == 4 ? 31 : 63;
            _ThreadCount = Math.Min(maxCPU, ThreadCount);
            _ThreadCount = Math.Max(1, _ThreadCount);
        }
        public event CommandTaskHandler CommandTask;
        public int FinishedTask;

        private int _ThreadCount;
        private ManualResetEvent[] waitHandles;
        private EventWaitHandle HaveTaskEvent = new AutoResetEvent(false);
        private EventWaitHandle ClearTaskEvent = new AutoResetEvent(false);
        private EventWaitHandle TaskFinishedEvent = new ManualResetEvent(false);
        private IParallelCommand TaskBridge = null;

        public void Start(string TaskName, ThreadPriority tp)
        {
            CreateWorkThread(TaskName, tp);
            foreach (IParallelCommand ieu in CommandTask())
            {
                Deliver(ieu);
            }
            TaskFinishedEvent.Set();
            EventWaitHandle.WaitAll(waitHandles);
        }

        private void Deliver(IParallelCommand ieu)
        {
            if (TaskBridge != null)
            {
                throw new ArithmeticException();
            }
            TaskBridge = ieu;
            WaitHandle.SignalAndWait(HaveTaskEvent, ClearTaskEvent);
        }

        private IParallelCommand Accept()
        {
            try
            {
                EventWaitHandle[] AcceptEvent = new EventWaitHandle[] { HaveTaskEvent, TaskFinishedEvent };
                int EventIndex = EventWaitHandle.WaitAny(AcceptEvent);
                if (EventIndex == 1)
                {
                    return null;
                }
                else
                {
                    IParallelCommand ifc = this.TaskBridge;
                    this.TaskBridge = null;
                    return ifc;
                }
            }
            finally
            {
                ClearTaskEvent.Set();
            }
        }

        private void CreateWorkThread(string TaskName, ThreadPriority tp)
        {
            waitHandles = new ManualResetEvent[this._ThreadCount];
            for (int i = 0; i < this._ThreadCount; i++)
            {
                waitHandles[i] = new ManualResetEvent(false);
                Thread thread = new Thread(ParallelThread);
                thread.IsBackground = true;
                thread.Priority = tp;
                thread.Name = String.Concat("UP_", TaskName, "_", i.ToString());
                thread.Start(i);
            }
        }

        private void ParallelThread(object oi)
        {
            int i = (int)oi;
            for (; ; )
            {
                IParallelCommand lt = Accept();
                if (lt == null)
                {
                    break;
                }
                Exception error = null;
                try
                {
                    log.DebugFormat("开始执行: {0}", DateTime.Now);
                    lt.Execute();
                }
                catch (Exception e)
                {
                    error = e;
                    log.ErrorFormat("执行失败: {0}", e);
                }
                finally
                {
                    try
                    {
                        log.DebugFormat("执行完成: {0}", DateTime.Now);
                        lt.Finished(new ParallelCommandFinishedEventArgs(null, error));
                    }
                    catch { }
                }
                Interlocked.Increment(ref FinishedTask);
            }
            waitHandles[i].Set();
        }
    }
}